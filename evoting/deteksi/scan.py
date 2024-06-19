import sys
import cv2
import pandas as pd
import time

# Camera and recognizer initialization
camera = 0
video = cv2.VideoCapture(camera, cv2.CAP_DSHOW)
face_Deteksi = cv2.CascadeClassifier('haarcascade_frontalface_default.xml')
recognizer = cv2.face.LBPHFaceRecognizer_create()
recognizer.read('DataSet/training.xml')

# Set confidence thresholds for face recognition
confidence_threshold_low = 53
confidence_threshold_high = 52

if len(sys.argv) != 2:
    print("Usage: python capture_faces.py <name>")
    sys.exit(1)

names = sys.argv[1]

# Initialize variables for tracking name stability
previous_name = None
name_start_time = time.time()

while True:
    check, frame = video.read()
    abu = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    wajah = face_Deteksi.detectMultiScale(abu, 1.3, 5)
    
    for (x, y, w, h) in wajah:
        cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
        
        # Recognize the face
        id, confidence = recognizer.predict(abu[y:y+h, x:x+w])
        
        # Load name from Excel file based on recognized ID
        df = pd.read_excel(f'excelData/{id}.xlsx')  # Assuming you have Excel files named by ID (e.g., '1.xlsx', '2.xlsx', ...)
        
        name = df.loc[df['ID'] == id, 'nama'].iloc[0]
        # Check if the ID matches the desired name
        if name == int(names):
            # name = df.loc[df['ID'] == id, 'nama'].iloc[0]
            
            # Display "Unknown" if confidence is outside the thresholds
            if confidence > confidence_threshold_low:
                # text = f"Unknown (: {confidence})"
                text = "Unknown"
                if time.time() - name_start_time >= 5:
                    print(f"undetect")
                    video.release()
                    cv2.destroyAllWindows()
                    sys.exit(0)
            else:
                # text = f"Name: {name} (: {confidence})"
                text = "Detect"
                
                # Check if the name has been the same as `names` for 5 seconds
                if previous_name == int(names):
                    if time.time() - name_start_time >= 5:
                        print(f"get detect")
                        video.release()
                        cv2.destroyAllWindows()
                        sys.exit(0)
                else:
                    previous_name = name
                    name_start_time = time.time()
        else:
            text = f"Is Not Your ID"
            previous_name = None
            if time.time() - name_start_time >= 5:
                print(f"undetect")
                video.release()
                cv2.destroyAllWindows()
                sys.exit(0)
        
        cv2.putText(frame, text, (x+40, y-10), cv2.FONT_HERSHEY_DUPLEX, 1, (0, 255, 0))

    
    cv2.imshow("Face Detection", frame)
    key = cv2.waitKey(1)
    
    # Press 'a' to exit the loop
    if key == ord('a'):
        break

video.release()
cv2.destroyAllWindows()