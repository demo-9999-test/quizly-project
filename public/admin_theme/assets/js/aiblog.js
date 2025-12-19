document.addEventListener('DOMContentLoaded', function() {
    const blogForm = document.getElementById('blogForm');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const blogContent = document.getElementById('blogContent');
    const imageGallery = document.getElementById('imageGallery');

    blogForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const title = document.getElementById('titleInput').value.trim();
        const wordCount = document.getElementById('wordCount').value;
        const imageCount = document.getElementById('imageCount').value;

        if (title === '' || wordCount === '' || imageCount === '') {
            alert('Please fill in all fields.');
            return;
        }

        loadingIndicator.style.display = 'block';
        blogContent.innerHTML = '';
        imageGallery.innerHTML = '';

        fetch('/blog/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                title: title,
                wordCount: parseInt(wordCount),
                imageCount: parseInt(imageCount)
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            loadingIndicator.style.display = 'none';
            blogContent.innerHTML = `<h2>${data.title}</h2>${data.content}`;

            data.images.forEach(imageUrl => {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-3';
                const img = document.createElement('img');
                img.src = imageUrl;
                img.className = 'img-fluid';
                img.alt = 'Generated Image';
                col.appendChild(img);
                imageGallery.appendChild(col);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            loadingIndicator.style.display = 'none';
            alert('An error occurred while generating the blog: ' + (error.error || 'Please try again later.'));
        });
    });
});
