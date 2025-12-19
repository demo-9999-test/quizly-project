<meta charset="utf-8">
@php
   $gsetting = \App\Models\GeneralSetting::first();
@endphp
<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of rtl languages
?>
<title>@yield('title')  {{  $gsetting->project_title ?? '' }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="Media City">
<meta name="MobileOptimized" content="320">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Theme Style -->
@if(in_array($language,$rtl))
<link href="{{url('front_theme/assets/css/bootstrap.rtl.min.css')}}" rel="stylesheet" type="text/css"> <!-- bootstrap css -->
@else
<link href="{{url('front_theme/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"> <!-- bootstrap css -->
@endif
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
<!-- fonts css -->
<link href="{{url('front_theme/vendor/slick/slick.css')}}" rel="stylesheet" type="text/css"> <!-- custom css -->
<link href="{{url('front_theme/vendor/wow/animate.css')}}" rel="stylesheet" type="text/css"> <!-- animate css -->
<link href="{{url('front_theme/assets/fonts/flaticon_quizzly_front.css')}}" rel="stylesheet" type="text/css"><!-- flaticon css -->
<link href="{{url('front_theme/vendor/froalaeditor/froala_editor.min.css')}}" rel="stylesheet">
<link href="{{url('front_theme/vendor/froalaeditor/froala_editor.pkgd.min.css')}}" rel="stylesheet">
<link href="{{url('front_theme/assets/css/venom-button.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{url('front_theme/vendor/apexchart/apexcharts.css')}}"><!-- apex chart css -->
<link rel="stylesheet" href="{{url('front_theme/vendor/daterange/daterangepicker.css')}}"><!--Date_Range_Picker-->
@if(isset($gsetting->favicon_logo) && !empty($gsetting->favicon_logo))<link rel="icon" type="image/icon" href="{{ asset('images/favicon/' .$gsetting->favicon_logo) }}">@endif <!-- favicon -->
@if(in_array($language,$rtl))
<link href="{{url('front_theme/assets/css/style_rtl.css')}}" rel="stylesheet" type="text/css"> <!-- custom css -->
@else
<link href="{{url('front_theme/assets/css/style.css')}}" rel="stylesheet" type="text/css"> <!-- custom css -->
@endif
<!-- end theme styles -->
