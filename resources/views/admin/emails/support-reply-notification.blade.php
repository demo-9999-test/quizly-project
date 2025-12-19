<!DOCTYPE html>
<html>
<head>
    <title>{{__('Welcome to')}} {{ config('app.name') }}</title>
</head>
<body>
    <p>{{__('Your support ticket has been updated with the following reply:')}}</p>

    <p>{{ $support->reply }}</p>

    <p>{{__('Thank you for using our support system.')}}</p>
</body>
</html>
