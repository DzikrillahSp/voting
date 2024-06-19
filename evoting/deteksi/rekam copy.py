import sys
import cv2
import pandas as pd
import os

camera = 0
video = cv2.VideoCapture(camera, cv2.CAP_DSHOW)
face_Deteksi = cv2.CascadeClassifier('haarcascade_frontalface_default.xml')

# Check if there is an existing DataFrame file to continue from the last ID
if os.path.exists('excelData/user_data.xlsx'):
    df = pd.read_excel('excelData/user_data.xlsx')
    last_id = df['ID'].max()
else:
    df = pd.DataFrame(columns=['ID', 'nama'])
    last_id = 0

# Prompt user to enter name
if len(sys.argv) != 3:
    print("Usage: python capture_faces.py <name>")
    sys.exit(1)

nama = sys.argv[1]
id2 = sys.argv[2]

# Increment the ID
id = last_id + 1

# Initialize a counter for image naming
a = 0

# Initialize a DataFrame to store metadata for the current user
user_data = {'ID': [], 'nama': []}

while True:
    a += 1
    check, frame = video.read()
    abu = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    wajah = face_Deteksi.detectMultiScale(abu, 1.3, 5)
    
    for (x, y, w, h) in wajah:
        # Save face image with unique filename based on ID and counter
        image_path = f'DataSet/User.{id}.{a}.jpg'
        cv2.imwrite(image_path, abu[y:y+h, x:x+w])
        cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
        
        # Append metadata to user_data
        user_data['ID'].append(id)
        user_data['nama'].append(nama)
    
    cv2.imshow("Face Detection", frame)
    
    # Limit number of images captured
    if a > 100:
        break

video.release()
cv2.destroyAllWindows()

# Convert user_data dictionary to DataFrame
user_df = pd.DataFrame(user_data)
df2 = pd.DataFrame(user_data)

# Save DataFrame to Excel
df2.to_excel(f'excelData/{id}.xlsx', index=False)
# Save the DataFrame to an Excel file named after the ID
# user_df.to_excel(f'{id}.xlsx', index=False)

# Update the overall DataFrame with the new user
df = pd.concat([df, user_df[['ID', 'nama']].drop_duplicates()], ignore_index=True)
df.to_excel('excelData/user_data.xlsx', index=False)

print(f"Data untuk '{nama}' telah disimpan di dataset dengan ID '{id}'.")
