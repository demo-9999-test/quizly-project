<!DOCTYPE html>
<html>
<head>
    <title>{{__('Welcome to')}} {{ config('app.name') }}</title>
</head>
<body>
    <p>{{__('A new support ticket has been created with the following details:')}}</p>
    <ul>
        <li>{{'Ticket ID: '. $ticket->ticket_id }}</li>
        <li>{{'Category: ' . $ticket->SupportType->name }}</li>
        <li>{{'Priority: ' . $ticket->priority }}</li>
        <li>{{'Message: ' . $ticket->message }}</li>
    </ul>
</body>
</html>
