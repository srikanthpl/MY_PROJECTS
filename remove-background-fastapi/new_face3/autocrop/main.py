from PIL import Image
from autocrop import Cropper

cropper = Cropper()

# Get a Numpy array of the cropped image
cropped_array = cropper.crop('Input_img/two.jpg')

# Save the cropped image with PIL if a face was detected
# Check if cropped_array is not None instead of using a boolean check
if cropped_array is not None:
    cropped_image = Image.fromarray(cropped_array)
    cropped_image.save('Output_img/cropped.png')
