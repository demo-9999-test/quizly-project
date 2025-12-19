"use strict";
$("#submitPassword").on('click', function(e) {
    e.preventDefault();
    var enteredPassword = $('#confirm_password').val();
    var urlLike = baseUrl + '/admin/validate-password';

    $.ajax({
        type: 'post',
        url: urlLike,
        data: {password: enteredPassword},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                document.getElementById('stripe_key').type = 'text';
                document.getElementById('stripe_secret_key').type = 'text';

                document.getElementById('paypal-client-id').type = 'text';
                document.getElementById('paypal-secret-id').type = 'text';

                document.getElementById('instamojo-api-key').type = 'text';
                document.getElementById('instamojo-auth-token').type = 'text';

                document.getElementById('razorpay-key').type = 'text';
                document.getElementById('razorpay-secret-key').type = 'text';

                document.getElementById('paystack-public-key').type = 'text';
                document.getElementById('paystack-secret-key').type = 'text';

                document.getElementById('paytm_merchant_id').type = 'text';
                document.getElementById('paytm_merchant_key').type = 'text';

                document.getElementById('omise_key').type = 'text';
                document.getElementById('omise_secret_key').type = 'text';

                document.getElementById('payu_merchant_key').type = 'text';

                document.getElementById('mollie_api_key').type = 'text';

                document.getElementById('cashfree_app_id').type = 'text';
                document.getElementById('cashfree_secret_key').type = 'text';

                document.getElementById('skrill_api_password').type = 'text';

                document.getElementById('rave_public_key').type = 'text';
                document.getElementById('rave_secret_key').type = 'text';
                document.getElementById('rave_secret_hash').type = 'text';

                document.getElementById('payhere_merchant_id').type = 'text';
                document.getElementById('payhere_business_app_code').type = 'text';
                document.getElementById('payhere_app_secret').type = 'text';

                document.getElementById('iyzico_api_key').type = 'text';
                document.getElementById('iyzico_secret_key').type = 'text';

                document.getElementById('ssl_store_id').type = 'text';
                document.getElementById('ssl_store_password').type = 'text';

                document.getElementById('aamarpay_store_id').type = 'text';
                document.getElementById('aamarpay_key').type = 'text';

                document.getElementById('braintree_public_key').type = 'text';
                document.getElementById('braintree_private_key').type = 'text';
                document.getElementById('braintree_merchant_id').type = 'text';

                document.getElementById('esewa_merchant_id').type = 'text';

                document.getElementById('smanager_client_id').type = 'text';
                document.getElementById('smanager_client_secret').type = 'text';

                document.getElementById('paytab_profile_id').type = 'text';
                document.getElementById('paytab_server_key').type = 'text';

                document.getElementById('company_token').type = 'text';

                document.getElementById('transaction_key').type = 'text';

                document.getElementById('bkash_app_secret').type = 'text';
                document.getElementById('bkash_app_key').type = 'text';
                document.getElementById('bkash_password').type = 'text';


                document.getElementById('mid_trans_client_key').type = 'text';
                document.getElementById('mid_trans_server_key').type = 'text';

                document.getElementById('square_pay_location_id').type = 'text';
                document.getElementById('square_access_token').type = 'text';
                document.getElementById('square_application_id').type = 'text';

                document.getElementById('worldpay_client_key').type = 'text';
                document.getElementById('worldpay_secret_key').type = 'text';

                document.getElementById('onepay_access_code').type = 'text';
                document.getElementById('onepay_secure_code').type = 'text';
                document.getElementById('onepay_merchant_id').type = 'text';

                document.getElementById('payflexi_public_key').type = 'text';
                document.getElementById('payflexi_secret_key').type = 'text';
                $('#exampleModal').modal('hide');
            }
        },

    });
});


$("#apisubmitPassword").on('click', function(e) {
    e.preventDefault();
    var enteredPassword = $('#confirm_password').val();
    var urlLike = baseUrl + '/admin/validate-password';

    $.ajax({
        type: 'post',
        url: urlLike,
        data: {password: enteredPassword},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                document.getElementById('recaptcha_site_key').type = 'text';
                document.getElementById('recaptcha_secret_key').type = 'text';
                document.getElementById('aws_key').type = 'text';
                document.getElementById('aws_secret_key').type = 'text';
                document.getElementById('youtube_api_key').type = 'text';
                document.getElementById('vimeo_client').type = 'text';
                document.getElementById('vimeo_secret').type = 'text';
                document.getElementById('google_tag_manager_id').type = 'text';
                document.getElementById('mailchip_api_key').type = 'text';
                document.getElementById('fb_pixel').type = 'text';
                $('#exampleModal').modal('hide');
            }
        },

    });
});


$("#socialsubmitPassword").on('click', function(e) {
    e.preventDefault();
    var enteredPassword = $('#confirm_password').val();
    var urlLike = baseUrl + '/admin/validate-password';

    $.ajax({
        type: 'post',
        url: urlLike,
        data: {password: enteredPassword},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                document.getElementById('fb_client_id').type = 'text';
                document.getElementById('fb_secret_key').type = 'text';
                document.getElementById('google_client_id').type = 'text';
                document.getElementById('google_client_key').type = 'text';
                document.getElementById('gitlab_client_id').type = 'text';
                document.getElementById('gitlab_client_key').type = 'text';
                document.getElementById('amazon_client_id').type = 'text';
                document.getElementById('amazon_client_key').type = 'text';
                document.getElementById('linkedin_client_id').type = 'text';
                document.getElementById('linkedin_client_key').type = 'text';
                document.getElementById('twitter_client_id').type = 'text';
                document.getElementById('twitter_client_key').type = 'text';
                $('#exampleModal').modal('hide');
            }
        },

    });
});


$("#smssubmitPassword").on('click', function(e) {
    e.preventDefault();
    var enteredPassword = $('#confirm_password').val();
    var urlLike = baseUrl + '/admin/validate-password';

    $.ajax({
        type: 'post',
        url: urlLike,
        data: {password: enteredPassword},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                document.getElementById('bulksms_password').type = 'text';
                document.getElementById('clicktail_api_key').type = 'text';
                document.getElementById('clicktail_password').type = 'text';
                document.getElementById('twilio_sid').type = 'text';
                document.getElementById('twilio_auth').type = 'text';
                document.getElementById('msg_auth_id').type = 'text';
                document.getElementById('msg_sender_id').type = 'text';
                document.getElementById('exabytes_password').type = 'text';
                document.getElementById('mimsms_sender_id').type = 'text';
                document.getElementById('mimsms_api').type = 'text';
                $('#exampleModal').modal('hide');
            }
        },

    });
});
