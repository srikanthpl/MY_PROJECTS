import os
import glob
import app.config as config
from PIL import Image
from PIL import Image, ImageEnhance

import cv2 
import numpy as np

def enhance_image(image_np):
    # Convert to HSV color space
    hsv = cv2.cvtColor(image_np, cv2.COLOR_BGR2HSV)
    # Split into channels
    h, s, v = cv2.split(hsv)
    # Increase saturation by a factor, for example, 1.3
    s = cv2.convertScaleAbs(s * 1.3)  # Adjust the multiplier as needed
    # Merge channels back
    enhanced_hsv = cv2.merge([h, s, v])
    # Convert back to BGR color space
    enhanced_img = cv2.cvtColor(enhanced_hsv, cv2.COLOR_HSV2BGR)
    return enhanced_img

def remove_representation():
    '''
    Delete all representation_*.pkl in database after execute DeepFace verify
    '''
    representations_path = glob.glob(os.path.join(config.DB_PATH, "representations_*.pkl"))
    if len(representations_path) != 0:
        for representation in representations_path:
            if os.path.exists(representation):
                os.remove(representation)

def check_empty_db():
    if len(os.listdir(config.DB_PATH)) == 0:
        return True
    return False

def show_img(input_path:str):
    '''
    Read image from path and show
    
    Arguments:
        input_path (str) Path to the input image.
    '''

    if not isinstance(input_path, str):
        raise TypeError("Only string is accepted, expect an input path as string.")
    
    if not os.path.exists(input_path):
        raise ValueError('Path to the image is not available.')

    try:
        image = Image.open(input_path)
        image.show()
    except:
        print("Error when reading image, check input_path.")


       