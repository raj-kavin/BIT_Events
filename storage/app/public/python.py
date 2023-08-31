from flask import Flask, request, jsonify
import face_recognition
import cv2

app = Flask(__name__)

def find_face_encodings(image_path):

        print(f"Processing image: {image_path}")
        # # reading image
        # image = cv2.imread(image_path)
        # time.sleep(5)
        # # get face encodings from the image
        # face_enc = face_recognition.face_encodings(image)
        # # return face encodings
        # return face_enc[0]
        print(f"Processing image...")
        image = cv2.imread(image_path)
        print(f"Processing image...")
        # Get face encodings from the image
        face_enc = face_recognition.face_encodings(image)

        if not face_enc:
            return None

        # Return the first face encoding
        return face_enc[0]


@app.route('/compare', methods=['POST'])
def compare_images():

    image1_data = request.files['image1'].read()
    image2_data = request.files['image2'].read()

    # Save binary data as image files
    with open('image1.jpg', 'wb') as image1_file:
        image1_file.write(image1_data)

    with open('image2.jpg', 'wb') as image2_file:
        image2_file.write(image2_data)

    print("Image 1 path:", 'image1.jpg')
    print("Image 2 path:", 'image2.jpg')

    # Load the saved image files using face_recognition
    # image1 = face_recognition.load_image_file('image1.jpg')
    # image2 = face_recognition.load_image_file('image2.jpg')

    image1_enc = find_face_encodings('image1.jpg')
    image2_enc = find_face_encodings('image2.jpg')

    if image1_enc is None or image2_enc is None:
        print("No faces")
        return jsonify({"result": "nofaces"})

    is_same = face_recognition.compare_faces([image1_enc], image2_enc)[0]

    print(f"Is Same: {is_same}")
    if is_same:
        # finding the distance level between images
        distance = face_recognition.face_distance([image1_enc], image2_enc)
        distance = round(distance[0] * 100)

        # calcuating accuracy level between images
        accuracy = 100 - round(distance)
        print("The images are same", accuracy)
        if accuracy>=55:
            return jsonify({"result": "same"})
        else:
            return jsonify({"result": "notclear"})
    else:
        return jsonify({"result": "notsame"})

if __name__ == '__main__':
    app.run(host='localhost', port=5000)

