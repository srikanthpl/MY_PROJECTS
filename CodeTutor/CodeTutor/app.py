from fastapi import FastAPI, HTTPException
from fastapi.responses import HTMLResponse, FileResponse
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from langchain.llms import Ollama
from langchain.callbacks.manager import CallbackManager
from langchain.callbacks.streaming_stdout import StreamingStdOutCallbackHandler
import asyncio

app = FastAPI()

# CORS middleware configuration
app.add_middleware(
    CORSMiddleware,
    allow_origins=["http://localhost:8081"],  # Allowed origins
    allow_credentials=True,
    allow_methods=["*"],  # Allowed methods
    allow_headers=["*"],  # Allowed headers
)

conversations = {}

class ConversationData(BaseModel):
    session_id: str
    message: str
    grade: str
    experience: str

class CodeData(BaseModel):
    user_code: str
    default_code: str
   

class WowsaWithMessageRequest(BaseModel):
    user_code: str
    user_message: str
    default_code:str
     
@app.get('/')
def home():
    return FileResponse('/home/srikanth/new_folder/CodeTutor/CodeTutor/one.html')
    #LLM model for chat generation
# llm = Ollama(model="llama2", callback_manager=CallbackManager([]))
llm = Ollama(model='mixtral', callback_manager=CallbackManager([StreamingStdOutCallbackHandler()]))


@app.post('/conversation')
async def conversation(data: ConversationData):
    session_id = data.session_id
    user_message = data.message
    grade = data.grade
    experience = data.experience

    tutor_prompt = f"Your Name is WOWSA an Expert Web Design HTML, CSS and JavaScript Tutor [Grade: {grade}, Experience: {experience}]: {user_message}\nTutor and if student asks code examples you will always give the complete html file with css and script not separate sections and code will be accurate and it should be very concise and accurate  "

    response_text = await asyncio.to_thread(llm, tutor_prompt)
    conversations[session_id] = f"{conversations.get(session_id, '')}Student: {user_message}\nTutor: {response_text}\n"

    # print("Response for /conversation:", response_text)  # Print response to terminal
    return {'answer': response_text}


@app.post('/ask_wowsa')
async def ask_wowsa(code_data: CodeData):
    user_code = code_data.user_code
    default_code = code_data.default_code  # New line to extract default_code

    prompt=("Your name is WOWSA, a Web Design Expert Analysis Report focusing on Default code comparison and giving ideas to match the 'user_code' to 'default_code' without giving the code snippets of default code or complete direction to make the user_code into default code which will make the users task easier. You should always give simple and short ideas and hints to the users regarding the user_code has some errors or why the default_code the main code and user_code has variations and matching you do not explain too much you will tell everything short and precise"
        
        f"User Code:\n{user_code}\n\nDefault Code:\n{default_code}\n\n"
    )

    response_text = await asyncio.to_thread(llm, prompt)

    # print("Response for /ask_wowsa:", response_text)  # Print response to terminal
    return {'answer': response_text}

@app.post('/ask_wowsa_with_message')
async def ask_wowsa_with_message(data: WowsaWithMessageRequest):
    user_code = data.user_code
    default_code = data.default_code
    user_message = data.user_message
    # prompt = f"Your name is WOWSA, an Expert in Web Design Analysis. Analyze the following code and provide a short,very concise ,accurate, crisp and straight to the point error analysis report with points on why the code might not be working. Also, consider the user's comment or question:\n\nCode:\n{data.code}\n\nUser's Comment: {data.user_message}\n\nResponse:"
    prompt=("Your name is WOWSA, a Web Design Expert Analysis Report focusing on Default code comparison and giving ideas to match the 'user_code' to 'default_code' without giving the code snippets of default code or complete direction to make the user_code into default code which will make the users task easier. You should always give simple and short ideas and hints to the users regarding the user_message. If user asks deeply, be prepared to give an in-depth explanation."
        f"User Code:\n{user_code}\n\nUser Message:{user_message}\n\nDefault Code:\n{default_code}\n\n"
    )
    response_text = await asyncio.to_thread(llm, prompt)

    # print("Response for /ask_wowsa_with_message:", response_text)  # Print response to terminal
    return {'answer': response_text}



if __name__ == '__main__':
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000, log_level="info")
