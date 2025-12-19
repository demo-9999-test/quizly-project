<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Account Deletion Request Approved') }}</title>
</head>
<body>
    <h1>{{ __('Account Deletion Request Approved') }}</h1>
    <p>{{ __('Dear :name,', ['name' => $user->name]) }}</p>
    <p>{{ __("We're writing to inform you that your request to delete your account has been approved and processed. Your account and all associated data have been permanently removed from our system.") }}</p>
    <p>{{ __('If you believe this action was taken in error or if you have any questions, please contact our support team immediately.') }}</p>
    <p>{{ __("Thank you for being a part of our community. We're sorry to see you go and hope you'll consider joining us again in the future.") }}</p>
    <p>{{ __('Best regards,') }}<br>{{ config('app.name') }}</p>
</body>
</html>
