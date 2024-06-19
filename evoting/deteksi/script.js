const video = document.getElementById('video');

// Load face-api.js models
Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
    faceapi.nets.faceRecognitionNet.loadFromUri('/models')
]).then(startVideo);

function startVideo() {
    navigator.mediaDevices.getUserMedia({ video: {} })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(err => console.error('Error accessing webcam: ', err));
}

video.addEventListener('play', () => {
    const canvas = faceapi.createCanvasFromMedia(video);
    document.body.append(canvas);
    const displaySize = { width: video.width, height: video.height };
    faceapi.matchDimensions(canvas, displaySize);

    setInterval(async () => {
        const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceDescriptors();
        const resizedDetections = faceapi.resizeResults(detections, displaySize);
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
        faceapi.draw.drawDetections(canvas, resizedDetections);
        faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);

        // Assuming you have pre-labeled face descriptors loaded as `labeledDescriptors`
        const labeledDescriptors = await loadLabeledImages();  // Define this function to load descriptors
        const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.6);
        const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor));

        results.forEach((result, i) => {
            const box = resizedDetections[i].detection.box;
            const text = result.toString();
            const drawBox = new faceapi.draw.DrawBox(box, { label: text });
            drawBox.draw(canvas);
        });
    }, 100);
});

async function loadLabeledImages() {
    const labels = ['Person1', 'Person2'];  // Add your labels here
    return Promise.all(
        labels.map(async label => {
            const descriptions = [];
            for (let i = 1; i <= 3; i++) {
                const img = await faceapi.fetchImage(`../labeled_images/${label}/${i}.jpg`);
                const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor();
                descriptions.push(detections.descriptor);
            }
            return new faceapi.LabeledFaceDescriptors(label, descriptions);
        })
    );
}
