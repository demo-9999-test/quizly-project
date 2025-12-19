@extends('admin.layouts.master')
@section('title', __('AI Blog'))
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('AI Blog') }}
    @endslot
    @slot('menu1')
    {{ __('AI Blog') }}
    @endslot
    @endcomponent

    <div class="ai-blog-generator bg-light min-vh-100 py-5">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-lg-3">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white text-black">
                            <h6 class="mb-0"><i class="fas fa-robot me-2"></i>{{ __('AI Blog Generator') }}</h6>
                        </div>
                        <div class="card-body">
                            <form id="blogForm">
                                <div class="mb-3">
                                    <label for="titleInput" class="form-label">{{ __('Blog Title') }}</label>
                                    <input type="text" class="form-control" id="titleInput" placeholder="{{ __('Enter blog title') }}" autocomplete="off" required>
                                </div>
                                <div class="mb-3">
                                    <label for="wordCount" class="form-label">{{ __('Word Count') }}: <span id="wordCountOutput">{{___('500')}}</span></label>
                                    <input type="range" class="form-range" id="wordCount" min="100" max="2000" step="100" value="500">
                                    <div class="d-flex justify-content-between">
                                        <small>{{__('100')}}</small>
                                        <small>{{__('2000')}}</small>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="imageCount" class="form-label">{{ __('Number of Images') }}: <span id="imageCountOutput">1</span></label>
                                    <input type="range" class="form-range" id="imageCount" min="0" max="5" step="1" value="1">
                                    <div class="d-flex justify-content-between">
                                        <small>{{__('0')}}</small>
                                        <small>{{__('5')}}</small>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-magic me-2"></i>{{ __('Generate Blog') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="card shadow h-100">
                        <div class="card-header bg-white text-black d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-newspaper me-2"></i>{{ __('Generated Blog') }}</h6>
                            <button id="copyButton" class="btn btn-light btn-sm" style="display: none;">
                                <i class="fas fa-copy me-1"></i>{{ __('Copy') }}
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="loadingIndicator" class="text-center py-5" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">{{ __('Loading...') }}</span>
                                </div>
                                <p class="mt-3 text-primary fw-bold">{{ __('Generating your blog...') }}</p>
                                <div class="progress mt-3" style="height: 10px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div id="noBlogMessage" class="text-center py-5" style="display: none;">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">{{ __('No blog created yet') }}</h5>
                                <p class="text-muted">{{ __('Please enter a title for your blog and click on Generate') }}</p>
                            </div>
                            <div id="blogContent" class="mt-3 fs-5 lh-lg text-dark"></div>
                            <div id="imageGallery" class="mt-4 row g-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('blogForm');
    const wordCountSlider = document.getElementById('wordCount');
    const wordCountOutput = document.getElementById('wordCountOutput');
    const imageCountSlider = document.getElementById('imageCount');
    const imageCountOutput = document.getElementById('imageCountOutput');
    const copyButton = document.getElementById('copyButton');
    const progressBar = document.querySelector('.progress-bar');

    wordCountSlider.addEventListener('input', function() {
        wordCountOutput.textContent = this.value;
    });

    imageCountSlider.addEventListener('input', function() {
        imageCountOutput.textContent = this.value;
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const title = document.getElementById('titleInput').value.trim();
        const wordCount = wordCountSlider.value;
        const imageCount = imageCountSlider.value;

        if (title === '') {
            showAlert('{{ __("Please enter a blog title.") }}', 'warning');
            return;
        }

        clearPreviousContent();
        showLoading();
        generateBlog(title, wordCount, imageCount);
    });

    copyButton.addEventListener('click', function() {
        const blogContent = document.getElementById('blogContent').innerText;
        navigator.clipboard.writeText(blogContent).then(() => {
            showAlert('{{ __("Blog content copied to clipboard!") }}', 'success');
        });
    });

    function showLoading() {
        document.getElementById('loadingIndicator').style.display = 'block';
        document.getElementById('noBlogMessage').style.display = 'none';
        simulateProgress();
    }

    function hideLoading() {
        document.getElementById('loadingIndicator').style.display = 'none';
        progressBar.style.width = '0%';
    }

    function simulateProgress() {
        let width = 0;
        const interval = setInterval(() => {
            if (width >= 90) {
                clearInterval(interval);
            } else {
                width += 10;
                progressBar.style.width = width + '%';
                progressBar.setAttribute('aria-valuenow', width);
            }
        }, 500);
    }

    function generateBlog(title, wordCount, imageCount) {
        fetch("{{ route('blog.create') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ title, wordCount: parseInt(wordCount), imageCount: parseInt(imageCount) })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('noBlogMessage').style.display = 'none';
            simulateTyping(data.content, document.getElementById('blogContent'));
            copyButton.style.display = 'block';
            setTimeout(() => renderImages(data.images), data.content.length * 20 + 1000);
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('{{ __("An error occurred while generating the blog. Please try again.") }}', 'danger');
        })
        .finally(() => hideLoading());
    }

    function simulateTyping(text, targetElement) {
        targetElement.innerHTML = '';
        targetElement.className = 'typing-animation';
        let index = 0;
        const typingInterval = setInterval(() => {
            if (index < text.length) {
                if (text[index] === '\n') {
                    targetElement.innerHTML += '<br>';
                } else {
                    targetElement.innerHTML += text[index];
                }
                index++;
            } else {
                clearInterval(typingInterval);
                targetElement.className = '';
            }
        }, 20);
    }

    function renderImages(images) {
        const imageGallery = document.getElementById('imageGallery');
        imageGallery.innerHTML = '';
        images.forEach(imageUrl => {
            const col = document.createElement('div');
            col.className = 'col-lg-4 col-md-6';
            const img = document.createElement('img');
            img.src = imageUrl;
            img.className = 'img-fluid rounded';
            col.appendChild(img);
            imageGallery.appendChild(col);
        });
    }

    function clearPreviousContent() {
        document.getElementById('blogContent').innerHTML = '';
        document.getElementById('imageGallery').innerHTML = '';
        document.getElementById('noBlogMessage').style.display = 'block';
        copyButton.style.display = 'none';
    }

    function showAlert(message, type) {
        const alert = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        document.getElementById('blogForm').insertAdjacentHTML('afterbegin', alert);
    }

    // Show the "No blog" message by default when the page loads
    document.getElementById('noBlogMessage').style.display = 'block';
});
</script>
@endsection
