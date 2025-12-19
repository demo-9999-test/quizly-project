<!DOCTYPE html>
<html lang="en">
<!-- <![endif]-->
<!-- head -->

<head>
    <meta charset="utf-8" />
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Media City" />
    <meta name="MobileOptimized" content="320" />
    <!-- <link rel="icon" type="image/icon" href="assets/images/general/favicon.png"> favicon-icon -->
    <!-- theme styles -->
    <link href="{{ url('admin_theme/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- bootstrap css -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"><!-- google fonts -->
    <link href="{{ url('admin_theme/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- fontawesome css -->
    <link type="text/css" href="{{ url('admin_theme/assets/fonts/font/flaticon_admin_collection.css') }}" rel="stylesheet">
    <!-- fonts css -->
    <link href="{{ url('admin_theme/assets/css/style.css') }}" rel="stylesheet" type="text/css" /> <!-- custom css -->
    <link href="{{ url('admin_theme/assets/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom css -->
    <!-- end theme styles -->
    {!! NoCaptcha::renderJs() !!}
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{__('Welcome to Our Demo')}}</h1>
                <p>{{__('Thank you for signing up for our demo. Heres a brief description of what you can expect:')}}</p>
                <p>{{__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed accumsan purus auctor elit elementum.')}}</p>
                <img src="{{ url('admin_theme/assets/images/general/logo.png') }}" alt="Demo Image" class="img-fluid">
                <p>{{__('If you have any questions or need assistance, please dont hesitate to contact us.')}}</p>
                <p><a href="{{route("reset.password", $token)}}" title="{{__('Reset Password')}}" class="btn btn-primary">{{__('Reset Password')}}</a></p>
            </div>
        </div>
    </div>

      <!-- jquery -->
      <script src="{{ url('admin_theme/assets/js/jquery.min.js') }}"></script> <!-- jquery library js -->
      <script src="{{ url('admin_theme/assets/js/bootstrap.bundle.min.js') }}"></script> <!-- bootstrap js -->
</body>
</html>
