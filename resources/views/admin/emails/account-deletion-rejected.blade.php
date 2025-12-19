<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Account Deletion Request Status') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        ul {
            margin: 0;
            padding: 0 0 0 20px;
        }
        li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>{{ __('Account Deletion Request Status') }}</h1>
    <p>{{ __('Dear :name,', ['name' => $user->name]) }}</p>
    <p>{{ __('We hope this email finds you well. We are writing to inform you about the status of your recent account deletion request.') }}</p>
    <p>{{ __('After careful review, we regret to inform you that we are unable to process your account deletion request at this time.') }}</p>
    <p>{{ __('This decision may be due to one or more of the following reasons:') }}</p>
    <ul>
        <li>{{ __('Ongoing contractual obligations') }}</li>
        <li>{{ __('Pending transactions or unresolved issues') }}</li>
        <li>{{ __('Current account status or specific account circumstances') }}</li>
    </ul>
    <p>{{ __('We understand this may not be the outcome you were expecting. If you would like to discuss this further or need more information about the status of your request, please don\'t hesitate to contact our dedicated support team. We\'re here to assist you and address any concerns you may have.') }}</p>
    <p>{{ __('Your account remains active, and you can continue to access and use our services as usual.') }}</p>
    <p>{{ __('We value your membership and appreciate your understanding in this matter. If there\'s anything we can do to improve your experience with our service, please let us know.') }}</p>
    <p>{{ __('Thank you for your continued trust in :appName.', ['appName' => config('app.name')]) }}</p>
    <p>
        {{ __('Best regards,') }}<br>
        {{ __('The :appName Team', ['appName' => config('app.name')]) }}
    </p>
</body>
</html>
