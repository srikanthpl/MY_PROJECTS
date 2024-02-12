""" from fastapi import FastAPI,Request
from starlette.responses import HTMLResponse
import mysql.connector
from fastapi.templating import Jinja2Templates

app = FastAPI()

# Database configuration
db_config = {
    "host": "localhost",
    "user": "sri",
    "password": "Sri@1234",
    "database": "coding",
}

templates = Jinja2Templates(directory="/home/srikanth/new_folder/CodeTutor/CodeTutor/static")

# Function to retrieve HTML code from the database
def get_html_code_from_db():
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
        cursor.execute("SELECT code FROM html WHERE id = 5")  # Adjust the SQL query as needed
        html_code = cursor.fetchone()[0]
        return html_code
    except Exception as e:
        print(f"Error retrieving HTML code from the database: {e}")
        return ""

@app.get("/", response_class=HTMLResponse)
async def index(request: Request):
    html_code = get_html_code_from_db()
    return templates.TemplateResponse("index.html", {"request": request, "html_code": html_code})  """


""" from fastapi import FastAPI, Request
from starlette.responses import HTMLResponse, FileResponse
import mysql.connector
from fastapi.templating import Jinja2Templates
import os
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()

# Database configuration
db_config = {
    "host": "localhost",
    "user": "sri",
    "password": "Sri@1234",
    "database": "coding",
}

templates = Jinja2Templates(directory="/home/srikanth/new_folder/CodeTutor/CodeTutor/static")

# Function to retrieve HTML code from the database
def get_html_code_from_db():
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
        cursor.execute("SELECT code FROM html WHERE id = 5")  # Adjust the SQL query as needed
        html_code = cursor.fetchone()[0]
        return html_code
    except Exception as e:
        print(f"Error retrieving HTML code from the database: {e}")
        return ""

# Configure CORS to allow requests from your frontend server
origins = ["http://localhost:8081"]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/", response_class=HTMLResponse)
async def index(request: Request):
    html_code = get_html_code_from_db()
    return templates.TemplateResponse("index.html", {"request": request, "html_code": html_code})

# Serve the frontend HTML file using FastAPI

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8081)
    """
""" from fastapi import FastAPI,Request
from starlette.responses import HTMLResponse
import mysql.connector
from fastapi.templating import Jinja2Templates
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()

# Configure CORS to allow requests from your frontend server
origins = ["http://localhost:8081"]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)
# Database configuration
db_config = {
    "host": "localhost",
    "user": "sri",
    "password": "Sri@1234",
    "database": "coding",
}

templates = Jinja2Templates(directory="/home/srikanth/new_folder/CodeTutor/CodeTutor")

# Function to retrieve HTML code from the database
def get_html_code_from_db():
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
        cursor.execute("SELECT code FROM html WHERE id = 5")  # Adjust the SQL query as needed
        html_code = cursor.fetchone()[0]
        return html_code
    except Exception as e:
        print(f"Error retrieving HTML code from the database: {e}")
        return ""

@app.get("/", response_class=HTMLResponse)
async def index(request: Request):
    html_code = get_html_code_from_db()
    return templates.TemplateResponse("index.html", {"request": request, "html_code": html_code}) """
""" from fastapi import FastAPI, HTTPException
from starlette.responses import JSONResponse
import mysql.connector

app = FastAPI()

# Database configuration
db_config = {
    "host": "localhost",
    "user": "sri",
    "password": "Sri@1234",
    "database": "coding",
}

@app.get("/api/get-html-code")
async def get_html_code():
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
        cursor.execute("SELECT code FROM html WHERE id = 2")  # Adjust as needed
        html_code = cursor.fetchone()
        if html_code:
            return JSONResponse(content={"html_code": html_code[0]})
        else:
            raise HTTPException(status_code=404, detail="HTML code not found")
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))
 """
""" 
from fastapi import FastAPI,Request
from starlette.responses import HTMLResponse
import mysql.connector
from fastapi.templating import Jinja2Templates

app = FastAPI()

# Database configuration
db_config = {
    "host": "localhost",
    "user": "sri",
    "password": "Sri@1234",
    "database": "coding",
}

templates = Jinja2Templates(directory="/home/srikanth/new_folder/CodeTutor/CodeTutor")

# Function to retrieve HTML code from the database
def get_html_code_from_db():
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
        cursor.execute("SELECT code FROM html WHERE id = 2")  # Adjust the SQL query as needed
        html_code = cursor.fetchone()[0]
        return html_code
    except Exception as e:
        print(f"Error retrieving HTML code from the database: {e}")
        return ""

@app.get("/", response_class=HTMLResponse)
async def index(request: Request):
    html_code = get_html_code_from_db()
    return templates.TemplateResponse("index.html", {"request": request, "html_code": html_code}) """

from fastapi import FastAPI
import mysql.connector
from fastapi.responses import JSONResponse
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()



app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # Allows all origins
    allow_credentials=True,
    allow_methods=["*"],  # Allows all methods
    allow_headers=["*"],  # Allows all headers
)
# Database configuration
db_config = {
    "host": "localhost",
    "user": "sri",
    "password": "Sri@1234",
    "database": "coding",
}

# Function to retrieve HTML code from the database
def get_html_code_from_db():
    try:
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor()
        cursor.execute("SELECT code FROM html WHERE id = 5")  # Adjust the SQL query as needed
        html_code = cursor.fetchone()[0]
        return html_code
    except Exception as e:
        print(f"Error retrieving HTML code from the database: {e}")
        return ""

@app.get("/api/get-html-code", response_class=JSONResponse)
async def get_html_code():
    html_code = get_html_code_from_db()
    return {"html_code": html_code}


