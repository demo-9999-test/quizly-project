document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('image').addEventListener('change', function(e) {
        const imagePreview = document.getElementById('imagePreview');
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    });
});
