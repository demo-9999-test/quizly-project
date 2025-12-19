(function($) {
    "use strict";

    /* ================================= */
    /*===== DatePicker =====*/
    /* ================================= */

    function setSidebarState() {
        var isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            $('html').addClass('is-collapsed');
            $('#sidebar-style').remove(); // Remove inline style
        } else {
            $('html').removeClass('is-collapsed');
        }
    }

    $(function() {
        $('#datepicker').datepicker();
        $('#datepicker-two').datepicker();
    });

    /* ================================= */
    /*===== Drag & Drop File =====*/
    /* ================================= */

    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
        const dropZoneElement = inputElement.closest(".drop-zone");

        if (dropZoneElement) {
            dropZoneElement.addEventListener("click", (e) => {
                inputElement.click();
            });

            inputElement.addEventListener("change", (e) => {
                if (inputElement.files.length) {
                    updateThumbnail(dropZoneElement, inputElement.files[0]);
                }
            });

            dropZoneElement.addEventListener("dragover", (e) => {
                e.preventDefault();
                dropZoneElement.classList.add("drop-zone--over");
            });

            ["dragleave", "dragend"].forEach((type) => {
                dropZoneElement.addEventListener(type, (e) => {
                    dropZoneElement.classList.remove("drop-zone--over");
                });
            });

            dropZoneElement.addEventListener("drop", (e) => {
                e.preventDefault();

                if (e.dataTransfer.files.length) {
                    inputElement.files = e.dataTransfer.files;
                    updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                }

                dropZoneElement.classList.remove("drop-zone--over");
            });
        }
    });

    /**
     * Updates the thumbnail on a drop zone element.
     *
     * @param {HTMLElement} dropZoneElement
     * @param {File} file
     */
    function updateThumbnail(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

        // First time - remove the prompt
        if (dropZoneElement.querySelector(".drop-zone__prompt")) {
            dropZoneElement.querySelector(".drop-zone__prompt").remove();
        }

        // First time - there is no thumbnail element, so lets create it
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumb");
            dropZoneElement.appendChild(thumbnailElement);
        }

        thumbnailElement.dataset.label = file.name;

        // Show thumbnail for image files
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            };
        } else {
            thumbnailElement.style.backgroundImage = null;
        }
    }

     /* ================================= */
        /*===== Sidebar Collapsed =====*/
        /* ================================= */
       // Set state on page load
    $(document).ready(function() {
        setSidebarState();

        $('.sidebar-toggle').on('click', function(e) {
            e.preventDefault();
            $('html').toggleClass('is-collapsed');
            localStorage.setItem('sidebarCollapsed', $('html').hasClass('is-collapsed'));
        });
    });

    /* ================================= */
    /*===== Full screen Icon =====*/
    /* ================================= */
    const fullscreenIcon = document.getElementById("fullscreen-icon");

    if (fullscreenIcon) {
        fullscreenIcon.addEventListener("click", () => {
            if (document.fullscreenElement) {
                exitFullscreen();
            } else {
                enterFullscreen();
            }
        });
    }

    function enterFullscreen() {
        const element = document.documentElement;
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }

        // Change the icon to an exit icon
        if (fullscreenIcon) {
            fullscreenIcon.classList.add("flaticon-full-screen");
            fullscreenIcon.classList.remove("flaticon-expand");
        }
    }

    function exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }

        // Change the icon back to the fullscreen icon
        if (fullscreenIcon) {
            fullscreenIcon.classList.remove("flaticon-full-screen");
            fullscreenIcon.classList.add("flaticon-expand");
        }
    }

    /* ================================= */
      /*===== slick slider =====*/
    /* ================================= */
    $(document).ready(function(){
        $('.top-user-slider').slick({
            slidesToShow: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
            infinite: true,
            responsive: [
            {
                breakpoint: 768,
                settings: {
                arrows: false,
                slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                arrows: false,
                slidesToShow: 1,
                dots:true
                }
            }
            ]
        });
    });
    $(document).ready(function(){
        $('.latest-quiz-slider').slick({
            slidesToShow: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            arrows: false,
            infinite: true,
            responsive: [
            {
                breakpoint: 768,
                settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                arrows: false,
                slidesToShow: 1,
                dots:true
                }
            }
            ]
        });
    });

})(jQuery);
