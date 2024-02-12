from fastapi import FastAPI, HTTPException, Request
from fastapi.responses import HTMLResponse
from fastapi.templating import Jinja2Templates
from pydantic import BaseModel
from langchain.llms import Ollama
from langchain.callbacks.manager import CallbackManager
import asyncio

app = FastAPI()
templates = Jinja2Templates(directory='templates')

class ChatRequest(BaseModel):
    session_id: str
    user_input: str

class SessionEndRequest(BaseModel):
    session_id: str

# Initialize Ollama model without StreamingStdOutCallbackHandler
llm = Ollama(model="mistral", callback_manager=CallbackManager([]))

chat_history = {}
fixed_prompt = "You are a web design specialist..."

@app.get("/", response_class=HTMLResponse)
async def read_root(request: Request):
    return templates.TemplateResponse("frontend.html", {"request": request})

@app.post("/chat/")
async def chat_with_llm(request: ChatRequest):
    session_id = request.session_id
    user_input = request.user_input

    history = chat_history.get(session_id, {"last_user_input": "", "last_ai_response": ""})
    updated_input = fixed_prompt + history["last_ai_response"] + user_input

    try:
        response_text = await asyncio.to_thread(llm, updated_input)
        chat_history[session_id] = {"last_user_input": user_input, "last_ai_response": response_text}
        return {"response": response_text}
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

@app.post("/end_session/")
async def end_session(request: SessionEndRequest):
    session_id = request.session_id
    if session_id in chat_history:
        del chat_history[session_id]
    return {"message": "Session ended and history cleared."}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8000)
