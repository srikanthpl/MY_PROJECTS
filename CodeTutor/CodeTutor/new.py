from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from langchain.llms import Ollama
from langchain.callbacks.manager import CallbackManager
from langchain.callbacks.streaming_stdout import StreamingStdOutCallbackHandler

app = FastAPI()

# Initialize Mixtral LLM
llm = Ollama(model='mixtral', callback_manager=CallbackManager([StreamingStdOutCallbackHandler()]))

# Global dictionary to store user data
user_data = {}

class ChatRequest(BaseModel):
    plan: str
    grade: str
    role: str
    topic: str
    date: str
    start_time: str
    end_time: str
    duration: str

class ExplanationRequest(BaseModel):
    response: str

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

def generate_ai_response(prompt):
    try:
        return llm(prompt)
    except Exception as e:
        return f"Error generating response: {e}"

@app.post('/chat')
def chat(request: ChatRequest):
    plan = 'Study plan' if request.role.lower() == 'student' else 'Lesson plan'
    prompt = f"Prepare an Exceptional detailed {plan.capitalize()} Plan for Grade {request.grade} {request.role} on the Subject of '{request.topic}' from {request.date}, {request.start_time} to {request.end_time} spanning {request.duration} Days."
    
    response = generate_ai_response(prompt)
    return {'response': response}

@app.post('/generate-explanation')
def generate_explanation(request: ExplanationRequest):
    prompt = f"""
    Generate a detailed lesson plan explanation for the topic and based on grade give me the explanation briefly or detailly '{request.response}'.
    Include:
    - A short summary of key concepts.
    - Practice questions and with quiz
    - Recommended websites and online resources for further learning.
    """
    response = generate_ai_response(prompt)
    return {'response': response}

if __name__ == '__main__':
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000, log_level="info")
