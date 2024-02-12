FROM nvidia/cuda:11.8.0-base-ubuntu20.04

# Set up a working directory
WORKDIR /app

# Install Python and pip
RUN apt-get update && \
    apt-get install -y python3 python3-pip && \
    rm -rf /var/lib/apt/lists/*

# Copy the requirements file and install Python dependencies
COPY requirements.txt .
RUN pip3 install --timeout=1000 --no-cache-dir -r requirements.txt

# Copy the rest of your application's code
COPY . .

# Command to run your application
# CMD ["python3", "main.py"]
CMD ["uvicorn", "app:app", "--host", "0.0.0.0", "--port", "80"]