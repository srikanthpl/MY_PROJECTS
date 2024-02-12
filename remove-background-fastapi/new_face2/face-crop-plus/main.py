""" from face_crop_plus import Cropper

cropper = Cropper(face_factor=0.7, strategy="largest")
cropper.process_dir(input_dir="/home/srikanth/new_folder/remove-background-fastapi/new_face2/face-crop-plus/images")"""  


""" from fastapi import FastAPI, UploadFile, File
from fastapi.responses import FileResponse
from face_crop_plus import Cropper
import os
import shutil
import uuid
import logging

app = FastAPI()
cropper = Cropper(face_factor=0.7, strategy="largest")

# Base directory for temporarily storing images
BASE_TEMP_DIR = "/home/srikanth/new_folder/remove-background-fastapi/new_face2/face-crop-plus/pro_img"

@app.post("/upload/")
async def process_image(file: UploadFile = File(...)):
    # Create a unique directory for this upload
    temp_dir = os.path.join(BASE_TEMP_DIR, str(uuid.uuid4()))
    os.makedirs(temp_dir, exist_ok=True)

    # Save the uploaded file in this directory
    temp_file_path = os.path.join(temp_dir, file.filename)
    with open(temp_file_path, "wb") as buffer:
        shutil.copyfileobj(file.file, buffer)

    # Process the directory
    try:
        cropper.process_dir(input_dir=temp_dir)
    except Exception as e:
        logging.error(f"Error during processing: {e}")
        # Handle the error appropriately

    # Check the contents of the temp_dir to understand the output naming convention
    logging.info(f"Contents of the directory after processing: {os.listdir(temp_dir)}")

    # Adjust the following line based on the actual naming convention or path
    cropped_file_name = "cropped_" + file.filename
    cropped_file_path = os.path.join(temp_dir, cropped_file_name)

    if not os.path.exists(cropped_file_path):
        logging.error(f"Cropped file not found at: {cropped_file_path}")
        # Handle error, maybe return an error response

    return FileResponse(cropped_file_path, media_type="image/jpeg")
 """
from fastapi import FastAPI, UploadFile, File
from fastapi.responses import FileResponse
from face_crop_plus import Cropper
import os
import shutil
import uuid
import logging

app = FastAPI()
cropper = Cropper(face_factor=0.7, strategy="largest")

# Base directory for temporarily storing images
BASE_TEMP_DIR = "/home/srikanth/new_folder/remove-background-fastapi/new_face2/face-crop-plus/pro_img"

@app.post("/upload/")
async def process_image(file: UploadFile = File(...)):
    # Create a unique directory for this upload
    temp_dir = os.path.join(BASE_TEMP_DIR, str(uuid.uuid4()))
    os.makedirs(temp_dir, exist_ok=True)

    # Save the uploaded file in this directory
    temp_file_path = os.path.join(temp_dir, file.filename)
    with open(temp_file_path, "wb") as buffer:
        shutil.copyfileobj(file.file, buffer)

    # Process the directory
    try:
        cropper.process_dir(input_dir=temp_dir)
    except Exception as e:
        logging.error(f"Error during processing: {e}")
        # Handle the error appropriately

    # Debug: Print the contents of the temp_dir
    processed_files = os.listdir(temp_dir)
    logging.info(f"Contents of the directory after processing: {processed_files}")

    # Adjust the filename based on the actual output of face_crop_plus
    # For example, if the filename remains unchanged, use the original filename
    cropped_file_path = os.path.join(temp_dir, file.filename)  # or use the correct modified filename

    if not os.path.exists(cropped_file_path):
        logging.error(f"Cropped file not found at: {cropped_file_path}")
        # Handle error, maybe return an error response

    return FileResponse(cropped_file_path, media_type="image/jpeg")


