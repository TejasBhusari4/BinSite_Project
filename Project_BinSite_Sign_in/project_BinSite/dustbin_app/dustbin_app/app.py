from flask import Flask, request, jsonify, render_template
from PIL import Image
import os

app = Flask(__name__,static_folder='../project_BinSite',template_folder='../project_BinSite')


# Route to upload image
@app.route('/upload', methods=['POST'])
def upload_image():
    if 'file' not in request.files:
        return jsonify({"error": "No file part"})
    file = request.files['file']
    if file.filename == '':
        return jsonify({"error": "No selected file"})
    if file:
        filename = file.filename
        file.save(os.path.join('uploads', filename))
        # For now, we just save the file. Add more processing later.
        return jsonify({"message": "File uploaded successfully", "filename": filename})
@app.route('/camera', methods=['GET'])
def camera():
    # Example response
    return jsonify({"status": "Camera access granted!"})

@app.route('/')
def index():
    return render_template('index.html')

if __name__ == '__main__':
    app.run(debug=True)

@app.route('/upload', methods=['POST'])
def upload_image():
    if 'file' not in request.files:
        return jsonify({"error": "No file part"})
    file = request.files['file']
    if file.filename == '':
        return jsonify({"error": "No selected file"})
    if file:
        filename = file.filename
        file.save(os.path.join('uploads', filename))
        
        # Extract location data
        latitude = request.form.get('latitude')
        longitude = request.form.get('longitude')

        return jsonify({
            "message": "File uploaded successfully",
            "filename": filename,
            "latitude": latitude,
            "longitude": longitude
        })

