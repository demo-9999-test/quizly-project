function showKeys() {
    $('#passwordModal').modal('show');
}

function verifyPassword() {
    const password = $('#password').val();

    // Send an AJAX request to verify the password
    $.ajax({
        url: verifyPasswordUrl, // The URL is passed from the Blade template
        method: 'POST',
        data: {
            _token: csrfToken, // The CSRF token is passed from the Blade template
            password: password
        },
        success: function(response) {
            if (response.success) {
                $('#passwordModal').modal('hide');
                const apiKeyField = document.getElementById('api_key');
                const listIdField = document.getElementById('list_id');

                apiKeyField.type = 'text';
                listIdField.type = 'text';

                setTimeout(() => {
                    apiKeyField.type = 'password';
                    listIdField.type = 'password';
                }, 5000); // Show for 5 seconds
            } else {
                alert('Incorrect password. Please try again.');
            }
        },
        error: function() {
            alert('An error occurred. Please try again.');
        }
    });
}
