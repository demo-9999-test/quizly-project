document.addEventListener("DOMContentLoaded", function() {
    var togglePassword = document.querySelectorAll(".toggle-password");

    togglePassword.forEach(function(element) {
        element.addEventListener("click", function() {
            element.classList.toggle("fa-eye");
            element.classList.toggle("fa-eye-slash");

            var input = document.querySelector(element.getAttribute("toggle"));
            if (input.getAttribute("type") === "password") {
                input.setAttribute("type", "text");
            } else {
                input.setAttribute("type", "password");
            }
        });
    });
});
