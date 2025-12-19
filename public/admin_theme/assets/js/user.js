document.addEventListener("DOMContentLoaded", function() {
    var input = document.querySelector("#phone");
    var fullPhoneInput = document.querySelector("#full_phone");
    var iti = window.intlTelInput(input, {
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "/admin_theme/assets/js/utils.js",
    });

    document.querySelector("form").addEventListener("submit", function() {
        fullPhoneInput.value = iti.getNumber();
    });

    const inputElements = document.querySelectorAll(".custom-input");
    inputElements.forEach(input => {
        input.oninput = function() {
            const inputValue = this.value;
            const slugValue = inputValue.replace(/\s+/g, "_");
            this.value = slugValue;
        };
    });

    // Add the flag-related CSS dynamically
    var style = document.createElement('style');
    style.textContent = `
        .iti__flag {
            background-image: url('/images/flags/flags.png');
        }
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .iti__flag {
                background-image: url('/images/flags/flags@2x.png');
            }
        }
    `;
    document.head.appendChild(style);
});
