""" from fastapi import FastAPI, File, UploadFile
from fastapi.responses import StreamingResponse
import cv2
import dlib
from imutils import face_utils
import os
import shutil
from typing import List
import io

app = FastAPI()

# Your existing crop_boundary and crop_face functions here
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

@app.post("/uploadfile/")
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

""" from fastapi import FastAPI, File, UploadFile
from fastapi.responses import StreamingResponse
import cv2
import dlib
from imutils import face_utils
import os
import shutil
import io

app = FastAPI()

def crop_boundary(top, bottom, left, right):
    # Reduced expansion to focus more on the face
    expansion_horizontal = 40  # Horizontal expansion
    expansion_vertical = 60    # Vertical expansion

    top = max(0, top - expansion_vertical)
    bottom += expansion_vertical
    left = max(0, left - expansion_horizontal)
    right += expansion_horizontal

    return top, bottom, left, right

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
        top, bottom, left, right = crop_boundary(y, y + h, x, x + w)
        crop_img_path = os.path.join(dirName, f"{basename_without_ext}_crop_{i}{extName}")
        crop_img = frame[top: bottom, left: right]
        cv2.imwrite(crop_img_path, cv2.cvtColor(crop_img, cv2.COLOR_RGB2BGR))

    return print(f"SUCCESS: [{basename}]")

# ... (Rest of the FastAPI code remains the same)
def clear_directory(dir_name):
    for f in os.listdir(dir_name):
        os.remove(os.path.join(dir_name, f))

@app.post("/uploadfile/")
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
        return {"message": "No faces detected or error in processing"} """

from fastapi import FastAPI, File, UploadFile
from fastapi.responses import StreamingResponse
import cv2
import dlib
from imutils import face_utils
import os
import shutil
from typing import List
import io

app = FastAPI()

def crop_boundary(top, bottom, left, right, faces):
    if faces:
        padding_top = 50  # Reduced padding
        padding_side = 30  # Reduced padding
    else:
        padding_top = 20  # Reduced padding
        padding_side = 10  # Reduced padding

    top = max(0, top - padding_top)
    left = max(0, left - padding_side)
    right += padding_side
    bottom += padding_top

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
        
        top, bottom, left, right = crop_boundary(y, y + h, x, x + w, len(rects) <= 2)
        crop_img_path = os.path.join(dirName, f"{basename_without_ext}_crop_{i}{extName}")
        crop_img = frame[top: bottom, left: right]
        cv2.imwrite(crop_img_path, cv2.cvtColor(crop_img, cv2.COLOR_RGB2BGR))

    print(f"SUCCESS: Cropped image saved for [{basename}]")

def clear_directory(dir_name):
    for f in os.listdir(dir_name):
        os.remove(os.path.join(dir_name, f))

@app.post("/uploadfile/")
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

# Add additional routes and logic as needed
 