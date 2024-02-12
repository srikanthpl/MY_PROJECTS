
# main.py
import os
import time
import PyPDF2
from torch import cuda, bfloat16
import transformers
import pinecone
from transformers import AutoConfig, AutoModelForCausalLM, AutoTokenizer, BitsAndBytesConfig
from langchain.llms import HuggingFacePipeline
from langchain.vectorstores import Pinecone
from langchain.chains import RetrievalQA
from langchain.embeddings.huggingface import HuggingFaceEmbeddings
import streamlit as st

# Install required packages from requirements.txt
# Uncomment the following lines if you want to install the packages automatically
# import subprocess
# subprocess.run(["pip", "install", "-r", "requirements.txt"])

# Set device
device = f'cuda:{cuda.current_device()}' if cuda.is_available() else 'cpu'

# Initialize HuggingFaceEmbeddings
embed_model_id = 'sentence-transformers/all-MiniLM-L6-v2'
embed_model = HuggingFaceEmbeddings(
    model_name=embed_model_id,
    model_kwargs={'device': device},
    encode_kwargs={'device': device, 'batch_size': 32}
)

docs = [
    "this is one document",
    "and another document"
]

embeddings = embed_model.embed_documents(docs)

print(f"We have {len(embeddings)} doc embeddings, each with "
      f"a dimensionality of {len(embeddings[0])}.")

# Initialize Pinecone
pinecone.init(
    api_key=os.environ.get('PINECONE_API_KEY') or '96ddc7c1-0a53-46b9-8198-fd8050b0bcd7',
    environment=os.environ.get('PINECONE_ENVIRONMENT') or 'asia-southeast1-gcp-free'
)

index_name = 'llama-2-rag'

if index_name not in pinecone.list_indexes():
    pinecone.create_index(
        index_name,
        dimension=len(embeddings[0]),
        metric='cosine'
    )
    # Wait for index to finish initialization
    while not pinecone.describe_index(index_name).status['ready']:
        time.sleep(1)

index = pinecone.Index(index_name)
index.describe_index_stats()

# Open the PDF file
pdf_file_path = '10th Standard Social Science EM.pdf'

with open(pdf_file_path, 'rb') as pdf_file:
    pdf_reader = PyPDF2.PdfReader(pdf_file)

    # Extract text from each page and store it in the 'data' variable
    data = ''
    for page in pdf_reader.pages:
        data += page.extract_text()

# Initialize the model
model_id = 'meta-llama/Llama-2-13b-chat-hf'

# Set quantization configuration to load a large model with less GPU memory
bnb_config = BitsAndBytesConfig(
    load_in_4bit=True,
    bnb_4bit_quant_type='nf4',
    bnb_4bit_use_double_quant=True,
    bnb_4bit_compute_dtype=bfloat16
)

# Begin initializing HF items, need auth token for these
hf_auth = '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'
model_config = AutoConfig.from_pretrained(
    model_id,
    use_auth_token=hf_auth
)

model = AutoModelForCausalLM.from_pretrained(
    model_id,
    trust_remote_code=True,
    config=model_config,
    quantization_config=bnb_config,
    device_map='auto',
    use_auth_token=hf_auth
)
model.eval()
print(f"Model loaded on {device}")

tokenizer = AutoTokenizer.from_pretrained(
    model_id,
    use_auth_token=hf_auth
)

generate_text = transformers.pipeline(
    model=model, tokenizer=tokenizer,
    return_full_text=True,  # langchain expects the full text
    task='text-generation',
    # we pass model parameters here too
    temperature=0.0,  # 'randomness' of outputs, 0.0 is the min and 1.0 the max
    max_new_tokens=512,  # max number of tokens to generate in the output
    repetition_penalty=1.1  # without this output begins repeating
)

st.title("Text Generation and Retrieval with LLM and RAG")

st.sidebar.header("Input")
input_text = st.sidebar.text_area("Enter text for LLM:", value="What was the role of Mustafa Kemal Pasha explain me in Tamil?")

# Generate text with LLM
if st.sidebar.button("Generate Text"):
    res = generate_text(input_text)
    st.subheader("Generated Text:")
    st.write(res[0]["generated_text"])

input_query = st.sidebar.text_area("Enter a query for RAG:", value="The Government of Tamil Nadu’s policy for “A Malnutrition Free Tamil Nadu” guides")

# Initialize HuggingFacePipeline
llm = HuggingFacePipeline(pipeline=generate_text)

text_field = 'text'  # field in metadata that contains text content

vectorstore = Pinecone(
    index, embed_model.embed_query, text_field
)

# Retrieve with RAG Pipeline
if st.sidebar.button("Retrieve with RAG"):
    results = vectorstore.similarity_search(input_query, k=3)
    st.subheader("RAG Retrieval Results:")
    for i, result in enumerate(results):
        st.write(f"Result {i+1}:")
        st.write(result["text"])

st.sidebar.header("About")
st.sidebar.info("This app uses Language Models for text generation (LLM) and Retrieval Augmented Generation (RAG) for text retrieval.")

