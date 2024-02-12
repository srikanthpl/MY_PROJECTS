from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import imgkit
from PIL import Image
from io import BytesIO
import logging
from fastapi.responses import JSONResponse
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()

# Initialize logging
logging.basicConfig(level=logging.INFO)

# Add CORS middleware
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

class HtmlContent(BaseModel):
    html1: str
    html2: str

def render_html_to_image(html_content: str) -> bytes:
    try:
        options = {
            'format': 'png',
            'encoding': "UTF-8",
        }
        img = imgkit.from_string(html_content, False, options=options)
        return img
    except Exception as e:
        logging.error(f"Error in render_html_to_image: {e}")
        raise

def compare_images(img1_bytes: bytes, img2_bytes: bytes) -> bool:
    try:
        img1 = Image.open(BytesIO(img1_bytes))
        img2 = Image.open(BytesIO(img2_bytes))

        return img1.tobytes() == img2.tobytes()
    except Exception as e:
        logging.error(f"Error in compare_images: {e}")
        raise

@app.post("/compare-designs/")
async def compare_designs(html_contents: HtmlContent):
    try:
        screenshot1 = render_html_to_image(html_contents.html1)
        screenshot2 = render_html_to_image(html_contents.html2)

        if compare_images(screenshot1, screenshot2):
            return {"statusCode": 200, "message": "Designs Matched"}
        else:
            return JSONResponse(status_code=400, content={"statusCode": 400, "message": "Designs Not Matched"})
    except Exception as e:
        logging.error(f"Error in compare_designs: {e}")
        raise HTTPException(status_code=500, detail=str(e))

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8003)
 