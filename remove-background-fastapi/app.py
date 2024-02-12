
from fastapi import FastAPI, UploadFile, File
from fastapi.responses import StreamingResponse
import uvicorn
import os
from datetime import datetime
from src import with_rembg
import shutil

app = FastAPI()

@app.get("/")
def hello():
    return {"API": "API is working fine"}

@app.post("/image_backgroung_remove")
async def upload_image(model_type: str = "1", img_file: UploadFile = File(...)):
    """
    Remove the background from an uploaded image file.

    Args:
        model_type (str): Model type, "1" for U2net and "2" for U2netp.
        img_file (UploadFile): The image file to process.

    Returns:
        StreamingResponse: The image with the background removed, streamed back to the client.
    """
    today_date = str(datetime.now().date())
    current_time = str(datetime.now().strftime("%H_%M_%S"))

    # Image extension validation
    valid_extensions = ('.jpg', '.jpeg', '.png')
    if img_file.filename.lower().endswith(valid_extensions):
        # Create directories if they don't exist
        upload_dir = f"./images/uploaded_images/{today_date}/"
        removed_bg_dir = f"./images/removed_bg/{today_date}/"
        os.makedirs(upload_dir, exist_ok=True)
        os.makedirs(removed_bg_dir, exist_ok=True)

        # Define file paths
        file_save_path = os.path.join(upload_dir, f"{current_time}_{img_file.filename}")
        file_output_path = os.path.join(removed_bg_dir, f"{current_time}_removed_bg_{img_file.filename}")

        # Save uploaded file
        with open(file_save_path, "wb") as f:
            shutil.copyfileobj(img_file.file, f)

        # Check file exists and remove background
        if os.path.exists(file_save_path):
            result = with_rembg.remove_background(file_save_path, file_output_path, model_type)

            if result['status'] == "success":
                # Return the processed image file directly
                def iterfile():
                    with open(result['file_out_path'], mode="rb") as file_like:
                        yield from file_like

                return StreamingResponse(iterfile(), media_type="image/png")
            else:
                return {"error": result['error'], "status": "fail"}
        else:
            return {"error": "Image not saved!", "status": "fail"}
    else:
        return {"error": "Invalid file type. Please upload JPG, JPEG, or PNG only.", "status": "fail"}

# Note: No need to call uvicorn.run when running with `uvicorn` command
