<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .error-image {
            max-width: 50%;
            height: auto;
        }
    </style>
</head>
<body>
    <img src="{{asset('images/error/Error 500.jpg')}}" alt="404 Error" class="error-image">
</body>
</html>
