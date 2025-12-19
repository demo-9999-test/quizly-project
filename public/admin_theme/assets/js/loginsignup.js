document.addEventListener('DOMContentLoaded', function() {
    const otpVerificationToggle = document.getElementById('otpVerificationToggle');
    const otpFields = document.getElementById('otpFields');

    function toggleOtpFields() {
        if (otpVerificationToggle.checked) {
            otpFields.style.display = 'block';
        } else {
            otpFields.style.display = 'none';
        }
    }

    otpVerificationToggle.addEventListener('change', toggleOtpFields);

    // Initial toggle on page load
    toggleOtpFields();
});
