document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.eye').forEach(eye => {
        eye.addEventListener('click', () => {
            const passwordInput = eye.previousElementSibling;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eye.classList.remove('flaticon-hide');
                eye.classList.add('flaticon-show');
            } else {
                passwordInput.type = 'password';
                eye.classList.remove('flaticon-show');
                eye.classList.add('flaticon-hide');
            }
        });
    });

    const switchUserType = (userType) => {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const userTypeInput = document.getElementById('user_type');

        if (userType === 'admin') {
            emailInput.value = 'admin@mediacity.co.in';
            passwordInput.value = '123456';
        } else if (userType === 'user') {
            emailInput.value = 'user@mediacity.co.in';
            passwordInput.value = '123456';
        }

        userTypeInput.value = userType;
    }

    document.querySelectorAll('.social-link a').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const userType = e.target.textContent.toLowerCase();
            switchUserType(userType);
        });
    });
});
