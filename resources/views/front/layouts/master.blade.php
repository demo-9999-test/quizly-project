<!DOCTYPE html>
<?php
$seo = \App\Models\SeoSetting::first();
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of rtl languages
?>
@if(in_array($language,$rtl))
<html lang="ar" dir="rtl">
@else
<html lang="en">
@endif
@laravelPWA

<head>
@include('front.layouts.header')
</head>
<!-- end head -->

<!-- body start-->
<body>
    @php
        $socialchat = \App\Models\SocialChat::first();
    @endphp

    @if($socialchat && $socialchat->whatsapp_enable_button)
        <div id="myButton" class="venom-button"></div>
    @endif
<!-- top-nav bar start-->
@include('front.layouts.topbar')
@include('front.layouts.flash_msg')
<!-- top-nav bar end-->
<!-- home start -->
@yield('content')
<!-- home end -->
<!-- footer start -->
@include('front.layouts.footer')
<!-- footer end -->
<!-- jquery -->
@include('front.layouts.script')
@yield('scripts')

@php
        $cookie = App\Models\Setting::first();
@endphp
@if ($cookie->cookie_status == 1)
    @include('cookie-consent::index')
@endif
<!-- end jquery -->
</body>
<!-- body end-->

