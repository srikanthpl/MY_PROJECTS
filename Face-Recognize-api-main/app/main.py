import os 
import glob
import shutil
import app.config as config
import cv2 as cv
from PIL import Image, ImageOps
from deepface import DeepFace
from app.utils import remove_representation, check_empty_db, enhance_image
from fastapi.responses import StreamingResponse,FileResponse
import uvicorn
from datetime import datetime
from app import with_rembg

from fastapi.middleware.cors import CORSMiddleware
from fastapi import FastAPI, Query, HTTPException, File, UploadFile, FastAPI, Form
import io
from deepface.commons import functions
import requests
from io import BytesIO
import numpy as np
import rembg
from rembg import remove, new_session
from face_recognition import load_image_file
import cv2
import dlib
from imutils import face_utils
import shutil
from typing import List


app = FastAPI(docs_url="/api")


try:
    from face_recognition import load_image_file
except ImportError as e:
    print(e)


origins = [
    # "http://localhost.tiangolo.com",
    # "https://localhost.tiangolo.com",
    # "http://localhost",
    # "http://localhost:8000",
    "*",
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=origins,
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/")
def root():
    '''
    Greeting!!!
    '''
    if os.path.exists(config.DB_PATH):
        return {
            "message": "Welcome to Face Recognition API."
        }
    else:
        return {
            "message": f"Error when trying to connect {config.DB_PATH}, there is no database available."
        }




def process_image(image: Image, to_gray: bool) -> np.ndarray:
    '''
    Enhance the image, remove the background and convert to gray scale if needed.
    '''
    if image.mode in ("RGBA", "P"):
        image = image.convert("RGB") 

    # Enhance image and remove background here using enhance_image and remove from rembg
    img_byte_arr = io.BytesIO()
    image.save(img_byte_arr, format='PNG')
    img_without_bg = remove(img_byte_arr.getvalue())
    enhanced_image = Image.open(io.BytesIO(img_without_bg))

    if config.RESIZE:
        enhanced_image = enhanced_image.resize(config.SIZE)

    np_image = np.array(enhanced_image)
    np_image = cv.cvtColor(np_image, cv.COLOR_RGB2BGR)

    if to_gray:
        np_image = cv.cvtColor(np_image, cv.COLOR_BGR2GRAY)

    # Convert to 3 channels if it is in grayscale
    if len(np_image.shape) == 2:
        np_image = cv.cvtColor(np_image, cv.COLOR_GRAY2BGR)

    return np_image

@app.post("/login_with_from_to_face_image/")
async def face_recognition_v2(
    registration_file: UploadFile = File(..., description="Registration image file"),
    login_file: UploadFile = File(..., description="Login image file"),
):
    '''
    Perform a one-time face recognition between a registration image and a login image.
    '''
    try:
        # Read and decode the registration image, which is already processed
        registration_contents = await registration_file.read()
        registration_nparr = np.frombuffer(registration_contents, np.uint8)
        registration_img_np = cv.imdecode(registration_nparr, cv.IMREAD_COLOR)

        # Read and decode the login image
        login_contents = await login_file.read()
        login_nparr = np.frombuffer(login_contents, np.uint8)
        login_img_np = cv.imdecode(login_nparr, cv.IMREAD_COLOR)


        # Remove the background from the login image
        login_img_without_bg = remove(login_img_np)
        login_img_without_bg_np = np.array(login_img_without_bg)
        login_img_without_bg_np = cv.cvtColor(login_img_without_bg_np, cv.COLOR_BGR2RGB)

        # Enhance the login image
        login_enhanced_np = enhance_image(login_img_without_bg_np)

        # Perform the face verification using DeepFace
        verification_result = DeepFace.verify(registration_img_np, login_enhanced_np, 
                                              model_name=config.MODELS[config.MODEL_ID],
                                              distance_metric=config.METRICS[config.METRIC_ID],
                                              detector_backend=config.DETECTORS[config.DETECTOR_ID],
                                              enforce_detection=False)
        
        # Return result based on verification outcome
        if verification_result["verified"]:
            return {
                "statusCode": 200,
                "message": "Face Match Successful",
                "data": {
                    "is_face_match": "true",
                    "is_found_kaggle": "false",
                    "kaggle_type": "0",
                }
            }
        else:
            return {
                "statusCode": 400,
                "message": "Face Match Unsuccessful",
                "data": {
                    "is_face_match": "false",
                    "is_found_kaggle": "false",
                    "kaggle_type": "0",
                }
            }

    except Exception as e:
        return {
            "statusCode": 500,
            "message": str(e),
            "data": {}
        }
    finally:
        registration_file.file.close()
        login_file.file.close()

@app.post("/login_with_from_to_face_id/")
async def ceph_image_recognition(country_code: str,customer_id:int,reg_user_face_id: str, login_user_face_id: UploadFile = File(..., description="Login image file")):
    '''
    Perform a one-time face recognition between a Ceph-stored registration image and a login image.
    '''
    try:
        # Construct URL for the Ceph image
        ceph_url = f"https://cephapi.getster.tech/api/storage/{country_code}-{customer_id}/{reg_user_face_id}"

        # Download image from Ceph URL
        response = requests.get(ceph_url, verify=False)
        if response.status_code != 200:
            raise HTTPException(status_code=404, detail="Ceph image not found")

        image_from_ceph = Image.open(BytesIO(response.content))

        # Convert RGBA Image to RGB if necessary
        if image_from_ceph.mode == 'RGBA':
            image_from_ceph = image_from_ceph.convert('RGB')

        # Save the Ceph image temporarily
        ceph_image_path = "tmp_ceph_image.jpg"
        image_from_ceph.save(ceph_image_path)

        # Read and decode the login image
        login_contents = await login_user_face_id.read()
        login_nparr = np.frombuffer(login_contents, np.uint8)
        login_img_np = cv.imdecode(login_nparr, cv.IMREAD_COLOR)

        # Remove the background from the login image
        login_img_without_bg = remove(login_img_np)
        login_img_without_bg_np = np.array(login_img_without_bg)
        login_img_without_bg_np = cv.cvtColor(login_img_without_bg_np, cv.COLOR_BGR2RGB)

        # Enhance the login image
        login_enhanced_np = enhance_image(login_img_without_bg_np)

        # Perform the face verification using DeepFace
        verification_result = DeepFace.verify(ceph_image_path, login_enhanced_np, 
                                              model_name=config.MODELS[config.MODEL_ID],
                                              distance_metric=config.METRICS[config.METRIC_ID],
                                              detector_backend=config.DETECTORS[config.DETECTOR_ID],
                                              enforce_detection=False)
        
        # Return result based on verification outcome
        if verification_result["verified"]:
            return {
                "statusCode": 200,
                "message": "Face Match Successful",
                "data": {
                    "is_face_match": "true",
                    "is_found_kaggle": "false",
                    "kaggle_type": "0",
                }
            }
        else:
            return {
                "statusCode": 400,
                "message": "Face Match Unsuccessful",
                "data": {
                    "is_face_match": "false",
                    "is_found_kaggle": "false",
                    "kaggle_type": "0",
                }
            }

    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

    finally:
        # Cleanup: close the file and remove the temporary image
        login_user_face_id.file.close()
        # os.remove(ceph_image_path)  # Uncomment if you want to remove the temporary file

# @app.post("/remove_face_img_bg/")
# async def bg_remove(image_file: UploadFile = File(...)):
#     try:
#         # Read the image file
#         contents = await image_file.read()
#         nparr = np.frombuffer(contents, np.uint8)
#         img_np = cv2.imdecode(nparr, cv2.IMREAD_COLOR)

#         # Remove the background
#         img_without_bg = remove(img_np)

#         # Convert the result back to a numpy array
#         img_without_bg_np = np.array(img_without_bg)

#         # Ensure the color is in RGB format
#         img_without_bg_np = cv2.cvtColor(img_without_bg_np, cv2.COLOR_BGR2RGB)

#         # Load OpenCV's Haar cascade for face detection
#         face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

#         # Detect faces on the enhanced image
#         faces = face_cascade.detectMultiScale(img_without_bg_np, 1.1, 4)

#         # Check if we found any faces, if not, use the entire image
#         if len(faces) == 0:
#             enhanced_img = enhance_image(img_without_bg_np)  # Use the whole image if no faces are detected
#         else:
#             # Sort the faces based on the area (w*h) and pick the largest one
#             faces = sorted(faces, key=lambda x: x[2] * x[3], reverse=True)
#             x, y, w, h = faces[0]
#             # Crop the largest face found
#             face = img_without_bg_np[y:y+h, x:x+w]
#             # Enhance the cropped face
#             enhanced_img = enhance_image(face)

#         # Convert the enhanced image to PIL Image
#         img_pil = Image.fromarray(enhanced_img)

#         # Save the final image to a bytes buffer
#         buf = BytesIO()
#         img_pil.save(buf, format="PNG")
#         byte_im = buf.getvalue()

#         # Return the image with the face cropped out and enhanced
#         return StreamingResponse(BytesIO(byte_im), media_type="image/png")
#     except Exception as e:
#         raise HTTPException(status_code=500, detail=str(e)) 


""" 
def crop_boundary(top, bottom, left, right, faces):
    if faces:
        top = max(0, top - 200)
        left = max(0, left - 100)
        right += 100
        bottom += 100
    else:
        top = max(0, top - 50)
        left = max(0, left - 50)
        right += 50
        bottom += 50

    return (top, bottom, left, right)

def crop_face(imgpath, dirName, extName):
    frame = cv2.imread(imgpath)
    basename = os.path.basename(imgpath)
    basename_without_ext = os.path.splitext(basename)[0]
    if frame is None:
        return print(f"Invalid file path: [{imgpath}]")
    frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    face_detect = dlib.get_frontal_face_detector()
    rects = face_detect(gray, 1)
    if not len(rects):
        return print(f"Sorry. HOG could not detect any faces from your image.\n[{imgpath}]")
    for (i, rect) in enumerate(rects):
        (x, y, w, h) = face_utils.rect_to_bb(rect)
        
        top, bottom, left, right = crop_boundary(y, y + h, x, x + w, len(rects) <= 2)
        crop_img_path = os.path.join(dirName, f"{basename_without_ext}_crop_{i}{extName}")
        crop_img = frame[top: bottom, left: right]
        cv2.imwrite(crop_img_path, cv2.cvtColor(crop_img, cv2.COLOR_RGB2BGR))

    return print(f"SUCCESS: [{basename}]")


def clear_directory(dir_name):
    for f in os.listdir(dir_name):
        os.remove(os.path.join(dir_name, f))

@app.post("/Face_Recognization_Crop/")
async def create_upload_file(file: UploadFile):
    dirName = "temp_results"
    os.makedirs(dirName, exist_ok=True)
    extName = ".png"

    # Clear the directory first
    clear_directory(dirName)

    # Save the uploaded file temporarily
    temp_file_path = f"temp_{file.filename}"
    with open(temp_file_path, 'wb') as buffer:
        shutil.copyfileobj(file.file, buffer)

    # Process the image
    crop_face(temp_file_path, dirName, extName)

    # Remove the temporary file
    os.remove(temp_file_path)

    # Read the first cropped image and return it
    cropped_files = os.listdir(dirName)
    if cropped_files:
        image_path = os.path.join(dirName, cropped_files[0])
        with open(image_path, "rb") as image_file:
            return StreamingResponse(io.BytesIO(image_file.read()), media_type="image/png")
    else:
        return {"message": "No faces detected or error in processing"}
     """

def crop_boundary(top, bottom, left, right, faces):
    if faces:
        # Reduce vertical padding to minimize hair inclusion
        padding_top = 20  # Reduced padding for top
        padding_bottom = 20  # Reduced padding for bottom
        # Increase horizontal padding to include ears
        padding_side = 100  # Increased padding for sides
    else:
        # Default padding when no faces are detected (fallback)
        padding_top = 20
        padding_bottom = 20
        padding_side = 50

    top = max(0, top - padding_top)
    left = max(0, left - padding_side)
    right += padding_side
    bottom += padding_bottom

    return (top, bottom, left, right)

def crop_face(imgpath, dirName, extName):
    frame = cv2.imread(imgpath)
    basename = os.path.basename(imgpath)
    basename_without_ext = os.path.splitext(basename)[0]
    if frame is None:
        return print(f"Invalid file path: [{imgpath}]")
    frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    face_detect = dlib.get_frontal_face_detector()
    rects = face_detect(gray, 1)
    if not len(rects):
        return print(f"No faces detected in the image: [{imgpath}]")
    for (i, rect) in enumerate(rects):
        (x, y, w, h) = face_utils.rect_to_bb(rect)
        
        # Use the modified crop_boundary function
        top, bottom, left, right = crop_boundary(y, y + h, x, x + w, len(rects) <= 2)
        crop_img_path = os.path.join(dirName, f"{basename_without_ext}_crop_{i}{extName}")
        crop_img = frame[top: bottom, left: right]
        cv2.imwrite(crop_img_path, cv2.cvtColor(crop_img, cv2.COLOR_RGB2BGR))

    print(f"SUCCESS: Cropped image saved for [{basename}]") 


def clear_directory(dir_name):
    for f in os.listdir(dir_name):
        os.remove(os.path.join(dir_name, f))

@app.post("/Face_Crop/")
async def create_upload_file(file: UploadFile):
    dirName = "temp_results"
    os.makedirs(dirName, exist_ok=True)
    extName = ".png"

    clear_directory(dirName)

    temp_file_path = f"temp_{file.filename}"
    with open(temp_file_path, 'wb') as buffer:
        shutil.copyfileobj(file.file, buffer)

    crop_face(temp_file_path, dirName, extName)

    os.remove(temp_file_path)

    cropped_files = os.listdir(dirName)
    if cropped_files:
        image_path = os.path.join(dirName, cropped_files[0])
        with open(image_path, "rb") as image_file:
            return StreamingResponse(io.BytesIO(image_file.read()), media_type="image/png")
    else:
        return {"message": "No faces detected or error in processing"}


def remove_background_in_memory(image_file, model_type):
    try:
        # Load the image from in-memory bytes
        image = Image.open(image_file)
        
        # Determine the model to use for background removal
        model_name = "u2net" if model_type == "1" else "u2netp" if model_type == "2" else None
        if not model_name:
            return {"error": "Model type is not specified correctly. Use 1 for u2net and 2 for u2netp", "status": "fail"}
        
        # Remove the background
        output_image = rembg.remove(image, session=new_session(model_name))
        
        # Convert the output image to bytes
        img_byte_arr = BytesIO()
        output_image.save(img_byte_arr, format='PNG')
        img_byte_arr = img_byte_arr.getvalue()
        
        return {"status": "success", "image_bytes": img_byte_arr}
    except Exception as e:
        return {"error": str(e), "message": "Error in removing background using rembg", "status": "fail"}

@app.post("/bg_remove/")
async def upload_image(model_type: str = "1", img_file: UploadFile = File(...)):
    """
    Remove the background from an uploaded image file and return the processed image without saving it.
    """
    contents = await img_file.read()
    result = remove_background_in_memory(BytesIO(contents), model_type)
    
    if result['status'] == "success":
        # Return the processed image directly from in-memory byte
        return StreamingResponse(BytesIO(result['image_bytes']), media_type="image/png")
    else:
        return {"error": result.get("error"), "status": "fail"}



async def crop_square(image_bytes: BytesIO):
    """
    Crop the uploaded image, which is assumed to have a transparent background,
    to a square shape, maintaining the transparent background.
    """
    image = Image.open(image_bytes)

    # Ensure the image is in RGBA format to maintain transparency
    if image.mode != 'RGBA':
        image = image.convert('RGBA')


    width, height = image.size
    min_side = min(width, height)

    # Calculate center and crop dimensions
    left = (width - min_side) / 2
    top = (height - min_side) / 2
    right = (width + min_side) / 2
    bottom = (height + min_side) / 2

    # Crop the image to a square
    image_cropped = image.crop((left, top, right, bottom))

    # Save cropped image to a bytes buffer
    img_byte_arr = io.BytesIO()
    image_cropped.save(img_byte_arr, format='PNG')  # Save as PNG to maintain transparency
    img_byte_arr.seek(0)  # Important to rewind to the start of the BytesIO object

    # Return the cropped image as a response
    return StreamingResponse(io.BytesIO(img_byte_arr.getvalue()), media_type="image/png")
  

@app.post("/process_full_image_workflow/")
async def process_image_end_to_end(image_file: UploadFile = File(...)):
    """
    This endpoint wraps the face cropping, background removal, and square cropping functionalities.
    The image uploaded by the user is processed through these steps sequentially.
    """
    # First, save the uploaded file temporarily
    temp_file_path = f"temp_{image_file.filename}"
    with open(temp_file_path, 'wb') as buffer:
        shutil.copyfileobj(image_file.file, buffer)

    # Step 1: Face Crop
    dirName = "temp_results"
    os.makedirs(dirName, exist_ok=True)
    extName = ".png"
    clear_directory(dirName)
    crop_face(temp_file_path, dirName, extName)
    cropped_files = os.listdir(dirName)
    if not cropped_files:
        return {"message": "No faces detected or error in processing during face cropping"}

    # Load the first cropped image for the next steps
    image_path = os.path.join(dirName, cropped_files[0])
    with open(image_path, "rb") as image_file_step1:
        contents_step1 = image_file_step1.read()

    
    # Step 2: Background Remove
    result_bg_remove = remove_background_in_memory(BytesIO(contents_step1), "1")
    if result_bg_remove['status'] != "success":
       return {"error": result_bg_remove.get("error"), "status": "fail during background removal"}


    # Step 3: Crop Square
    result_crop_square = await crop_square(BytesIO(result_bg_remove['image_bytes']))
    if isinstance(result_crop_square, StreamingResponse):
        return result_crop_square
    else:
        return {"message": "Error during square cropping"}

    # Cleanup temporary files
    os.remove(temp_file_path)
    clear_directory(dirName)


