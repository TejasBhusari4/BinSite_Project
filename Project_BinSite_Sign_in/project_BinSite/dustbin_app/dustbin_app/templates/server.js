const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const path = require('path');

const app = express();
app.use(bodyParser.urlencoded({ extended: true }));

app.post('/upload', (req, res) => {
    const fileData = req.body.file; // The base64 image data URL
    if (fileData) {
        const base64Data = fileData.replace(/^data:image\/png;base64,/, '');
        fs.writeFile('uploaded-image.png', base64Data, 'base64', (err) => {
            if (err) {
                console.error('Error saving image:', err);
                res.status(500).send('Error saving image.');
            } else {
                res.send('Image uploaded successfully.');
            }
        });
    } else {
        res.status(400).send('No image data received.');
    }
});

app.listen(3000, () => {
    console.log('Server running on http://localhost:3000');
});