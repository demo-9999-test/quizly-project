// team-member-create.js

document.addEventListener('DOMContentLoaded', function() {
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('image');
    const captureButton = document.getElementById('capture-button');
    const imageGrid = document.getElementById('image-grid');
    const cameraModal = document.getElementById('cameraModal');
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const snapButton = document.getElementById('snap');
    const closeModalButton = document.getElementById('closeModal');
    let stream;

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropArea.classList.add('highlight');
    }

    function unhighlight(e) {
        dropArea.classList.remove('highlight');
    }

    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        [...files].forEach(previewFile);
    }

    fileInput.addEventListener('change', function(e) {
        handleFiles(this.files);
    });

    captureButton.addEventListener('click', openCamera);
    closeModalButton.addEventListener('click', closeCamera);

    function openCamera() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                .then(function(str) {
                    stream = str;
                    video.srcObject = stream;
                    video.onloadedmetadata = function(e) {
                        video.play();
                        cameraModal.style.display = 'flex';
                    };
                })
                .catch(function(error) {
                    console.error("Error accessing the camera:", error);
                    alert("Unable to access the camera. Please make sure you've granted the necessary permissions.");
                });
        } else {
            alert("Sorry, your browser doesn't support accessing the camera.");
        }
    }

    function closeCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        cameraModal.style.display = 'none';
    }

    snapButton.addEventListener('click', function() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        closeCamera();

        canvas.toBlob(function(blob) {
            const file = new File([blob], "camera_capture.jpg", { type: "image/jpeg" });
            previewFile(file);

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
        }, 'image/jpeg');
    });

    function previewFile(file) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onloadend = function() {
            imageGrid.innerHTML = '';
            const img = document.createElement('img');
            img.src = reader.result;
            img.style.maxWidth = '100%';
            img.style.maxHeight = '300px';
            img.style.objectFit = 'contain';
            imageGrid.appendChild(img);
        };
    }
});
