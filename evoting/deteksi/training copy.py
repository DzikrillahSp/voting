import cv2
import os
import numpy as np
from PIL import Image

# Create recognizer and detector objects
recognizer = cv2.face.LBPHFaceRecognizer_create()
detector = cv2.CascadeClassifier("haarcascade_frontalface_default.xml")

# Define function to get images and labels
def getImagesWithLabels(path):
    imagePaths = [os.path.join(path, f) for f in os.listdir(path)]
    faceSamples = []
    Ids = []
    for imagePath in imagePaths:
        pilImage = Image.open(imagePath).convert('L')
        imageNp = np.array(pilImage, 'uint8')
        Id = int(os.path.split(imagePath)[-1].split(".")[1])
        faces = detector.detectMultiScale(imageNp)
        for (x, y, w, h) in faces:
            faceSamples.append(imageNp[y:y+h, x:x+w])
            Ids.append(Id)
    return faceSamples, Ids

# Check if training.xml exists and delete it if it does
training_file = 'DataSet/training.xml'
if os.path.exists(training_file):
    os.remove(training_file)
    print(f"Removed existing training file: {training_file}")

# Get faces and IDs
faces, Ids = getImagesWithLabels('DataSet')

# Train the recognizer and save the model
recognizer.train(faces, np.array(Ids))
recognizer.save(training_file)
print(f"Training complete and saved to: {training_file}")
