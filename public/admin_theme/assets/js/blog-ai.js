document.addEventListener('DOMContentLoaded', function() {
    let envVariablesChecked = false;

    checkEnvVariables();

    function checkEnvVariables() {
        fetch(window.routes.checkEnvVariables)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const contentType = response.headers.get("content-type");
                if (!contentType || !contentType.includes("application/json")) {
                    throw new TypeError("Oops, we haven't got JSON!");
                }
                return response.json();
            })
            .then(data => {
                if (data.missingKeys && data.missingKeys.length > 0) {
                    showMissingKeysPopup(data.missingKeys);
                } else {
                    envVariablesChecked = true;
                }
            })
            .catch(error => {
                console.error('Error checking env variables:', error);
                if (error instanceof TypeError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'The server returned an unexpected response. Please try again later or contact support.',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while checking environment variables. Please try again.',
                    });
                }
            });
    }

    function showMissingKeysPopup(missingKeys) {
        Swal.fire({
            title: 'Missing API Keys',
            html: `The following API keys are missing in your .env file:<br><br>${missingKeys.join('<br>')}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Update Keys',
            cancelButtonText: 'Later'
        }).then((result) => {
            if (result.isConfirmed) {
                showUpdateKeysModal(missingKeys);
            } else {
                envVariablesChecked = false;
            }
        });
    }

    function showUpdateKeysModal(missingKeys) {
        let modalContent = `
            <div class="modal fade" id="updateKeysModal" tabindex="-1" aria-labelledby="updateKeysModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateKeysModalLabel">Update API Keys</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="updateKeysForm">
                                ${missingKeys.map(key => `
                                    <div class="mb-3">
                                        <label for="${key}" class="form-label">${key}</label>
                                        <input type="text" class="form-control" id="${key}" name="${key}" required>
                                    </div>
                                `).join('')}
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveKeysBtn">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalContent);
        const modal = new bootstrap.Modal(document.getElementById('updateKeysModal'));
        modal.show();

        document.getElementById('saveKeysBtn').addEventListener('click', function() {
            const form = document.getElementById('updateKeysForm');
            const formData = new FormData(form);

            fetch(window.routes.UpdateEnvVariables, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success',
                        text: 'API keys have been updated successfully.',
                        icon: 'success'
                    }).then(() => {
                        modal.hide();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to update API keys. Please try again.',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error updating env variables:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again.',
                    icon: 'error'
                });
            });
        });
    }

    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const selectImagesBtn = document.getElementById('selectImagesBtn');
    const imageSelectionModal = new bootstrap.Modal(document.getElementById('imageSelectionModal'));
    const modalImageSelectionArea = document.getElementById('modalImageSelectionArea');
    const selectedImagePreview = document.getElementById('selectedImagePreview');
    const localImagesInput = document.getElementById('localImages');
    const localImageRadio = document.getElementById('localImageRadio');
    const generatedImageRadio = document.getElementById('generatedImageRadio');
    const localImageUploadSection = document.getElementById('localImageUploadSection');
    const generatedImageSelectSection = document.getElementById('generatedImageSelectSection');
    const aiGenerateBtn = document.getElementById('aiGenerateBtn');
    const aiModelSelectionModal = new bootstrap.Modal(document.getElementById('aiModelSelectionModal'));
    const imageSourceSelectionModal = new bootstrap.Modal(document.getElementById('imageSourceSelectionModal'));
    let generatedImages = [];
    let currentImageIndex = 0;
    let selectedAiModel = '';
    let selectedImageSource = '';

    var description = new SimpleMDE({ element: document.getElementById("authorDescription") });

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    aiGenerateBtn.addEventListener('click', function() {
        const title = titleInput.value.trim();
        if (title) {
            if (!envVariablesChecked) {
                checkEnvVariables();
            } else {
                aiModelSelectionModal.show();
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter a title first.',
            });
        }
    });

    document.querySelectorAll('.ai-model-card').forEach(card => {
        card.addEventListener('click', function() {
            selectedAiModel = this.dataset.model;
            aiModelSelectionModal.hide();
            generateContent(selectedAiModel);
        });
    });

    document.querySelectorAll('.image-source-card').forEach(card => {
        card.addEventListener('click', function() {
            selectedImageSource = this.dataset.source;
            imageSourceSelectionModal.hide();
            generateImages(titleInput.value.trim(), selectedImageSource);
        });
    });

    function generateContent(model) {
        if (!envVariablesChecked) {
            checkEnvVariables();
            return;
        }

        const title = titleInput.value.trim();
        if (!title) return;

        Swal.fire({
            title: 'Generating Content',
            html: `Please wait while we generate the description using ${model.toUpperCase()}...`,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(window.routes.genrateblog, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ title, model })
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.content) {
                description.value(data.content);
                Swal.fire({
                    icon: 'success',
                    title: 'Description Generated',
                    text: `The description has been generated successfully using ${model.toUpperCase()}.`,
                    timer: 1500
                }).then(() => {
                    imageSourceSelectionModal.show();
                });
            } else {
                throw new Error('Error generating description');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error generating description. Please try again.',
            });
        });

        slugInput.value = title.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
    }

    function generateImages(title, source) {
        Swal.fire({
            title: 'Generating Images',
            html: `Please wait while we generate images using ${source.toUpperCase()}...`,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(window.routes.genrateimage, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ title, source })
        })
        .then(response => response.json())
        .then(data => {
            if (data.images && data.images.length > 0) {
                generatedImages = data.images;
                Swal.fire({
                    icon: 'success',
                    title: 'Images Generated',
                    text: 'Images have been generated. Click "Select Generated Image" to view and select them.',
                });
            } else {
                throw new Error('No images were generated');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error generating images. Please try again.',
            });
        });
    }

    function loadMoreImages() {
        const remainingImages = generatedImages.slice(currentImageIndex, currentImageIndex + 5);
        const imageHtml = remainingImages.map(imgUrl => `
            <div class="col-md-4 mb-3">
                <img src="${imgUrl}" alt="Generated Image" class="img-fluid rounded cursor-pointer generated-image" onclick="selectGeneratedImage(this)">
            </div>
        `).join('');

        modalImageSelectionArea.insertAdjacentHTML('beforeend', imageHtml);
        currentImageIndex += 5;

        if (currentImageIndex >= generatedImages.length || currentImageIndex >= 20) {
            document.getElementById('loadMoreBtn').style.display = 'none';
        }
    }

    selectImagesBtn.addEventListener('click', function() {
        if (generatedImages.length > 0) {
            modalImageSelectionArea.innerHTML = '';
            currentImageIndex = 0;
            loadMoreImages();

            if (generatedImages.length > 5) {
                const loadMoreBtn = document.createElement('button');
                loadMoreBtn.id = 'loadMoreBtn';
                loadMoreBtn.className = 'btn btn-primary mt-3';
                loadMoreBtn.textContent = 'See More';
                loadMoreBtn.onclick = loadMoreImages;
                modalImageSelectionArea.insertAdjacentElement('afterend', loadMoreBtn);
            }

            imageSelectionModal.show();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No Images',
                text: 'No images have been generated yet. Please click the AI Generate button first.',
            });
        }
    });

    window.selectGeneratedImage = function(img) {
        document.querySelectorAll('.generated-image').forEach(el => el.classList.remove('selected-ai'));
        img.classList.add('selected-ai');
    };

    document.getElementById('saveSelectedImage').addEventListener('click', function() {
        const selectedImage = modalImageSelectionArea.querySelector('.selected-ai');
        if (selectedImage) {
            updateSelectedImagePreview(selectedImage.src);
            document.getElementById('generatedImageUrl').value = selectedImage.src;
            selectImagesBtn.value = 'Image Selected';
            imageSelectionModal.hide();
            Swal.fire({
                icon: 'success',
                title: 'Image Selected',
                text: 'The selected image has been saved.',
                timer: 1500
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select an image before saving.',
            });
        }
    });

    localImageRadio.addEventListener('change', function() {
        localImageUploadSection.style.display = 'block';
        generatedImageSelectSection.style.display = 'none';
    });

    generatedImageRadio.addEventListener('change', function() {
        localImageUploadSection.style.display = 'none';
        generatedImageSelectSection.style.display = 'block';
    });

    function updateSelectedImagePreview(imageUrl) {
        selectedImagePreview.innerHTML = `
            <img src="${imageUrl}" alt="Selected Image" class="img-fluid rounded">
        `;
    }

    localImagesInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                updateSelectedImagePreview(e.target.result);
                document.getElementById('generatedImageUrl').value = '';
            };
            reader.readAsDataURL(file);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Invalid File',
                text: 'Please select a valid image file.',
            });
        }
    });

    document.querySelectorAll('.copy-post').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const postId = this.getAttribute('data-id');
            copyPost(postId);
        });
    });

    function copyPost(id) {
        Swal.fire({
            title: 'Copying Post',
            html: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        fetch(window.routes.copyblog, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Post Copied',
                    text: data.message,
                }).then(() => {
                    window.location.reload();
                });
            } else {
                throw new Error(data.message || 'Error copying post');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error copying post. Please try again.',
            });
        });
    }
});
