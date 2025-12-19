document.addEventListener('DOMContentLoaded', function () {
    const timerElement = document.getElementById('timer');
    const resendSection = document.getElementById('resendSection');
    const timerSection = document.getElementById('timerSection');
    let timeLeft = 30;
    let timerId;
    const urlLike = baseUrl + "/resend-otp";

    function updateTimer() {
        if (timeLeft > 0) {
            timerElement.textContent = timeLeft;
            timeLeft--;
            timerId = setTimeout(updateTimer, 1000);
        } else {
            timerSection.style.display = 'none';
            resendSection.style.display = 'block';
        }
    }

    function resetTimer() {
        clearTimeout(timerId);
        timeLeft = 30;
        timerSection.style.display = 'block';
        resendSection.style.display = 'none';
        updateTimer();
    }

    function showMessage(message, isError = false) {
        const alertClass = isError ? 'alert-danger' : 'alert-success';
        const alertElement = document.createElement('div');
        alertElement.className = `alert ${alertClass} success-message`;
        alertElement.textContent = message;

        const registerDtls = document.querySelector('.register-dtls');
        registerDtls.insertBefore(alertElement, registerDtls.firstChild);

        setTimeout(() => alertElement.remove(), 5000);
    }

    function resendOTP() {
    const contact = document.getElementById('userContact').value.trim();
    let data = {};

    // Debug: Show what contact was detected
    console.log("Contact value:", contact);

    // Handle country codes if needed (for mobile)
    if (/^\+?\d{10,15}$/.test(contact)) {
        data.mobile = contact;
    } else if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(contact)) {
        data.email = contact;
    } else {
        showMessage('Invalid mobile number or email.', true);
        return;
    }

    resendSection.innerHTML = '<span><i class="fas fa-spinner fa-spin"></i> Resending OTP...</span>';

    $.ajax({
        url: urlLike,
        method: "POST",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            if (data.message) {
                showMessage(data.message);
                resetTimer();
            } else {
                showMessage(data.error || 'Failed to resend OTP. Please try again.', true);
            }
        },
        error: function (xhr) {
            const response = xhr.responseJSON || {};
            const message = response.error || response.message || 'An error occurred. Please try again.';
            console.error("Resend OTP error:", response);
            showMessage(message, true);
        },
        complete: function () {
            setTimeout(function () {
                resendSection.innerHTML = '<a id="resendLink" class="text-primary text-decoration-none cursor-pointer">Resend OTP</a>';
                bindResendLink();
            }, 3000);
        }
    });
}

    updateTimer();
    bindResendLink();
});
