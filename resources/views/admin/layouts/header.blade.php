@php
     $setting = \App\Models\GeneralSetting::first();
@endphp
<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of rtl languages
?>
@if(isset($setting->favicon_logo) && !empty($setting->favicon_logo))<link rel="icon" type="image/icon" href="{{ asset('images/favicon/' . $setting->favicon_logo) }}">@endif
<!-- theme styles -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"rel="stylesheet"><!-- google fonts -->
@if(in_array($language,$rtl))
<link rel="stylesheet" href="{{ url('assets/css/bootstrap.rtl.min.css') }}" type="text/css"/> <!-- bootstrap rtl css -->
@else
<link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> <!-- bootstrap css -->
@endif
<!-- <link href="{{ url('admin_theme/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" /> -->
<!-- fontawesome css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="{{ url('admin_theme/assets/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://icons.getbootstrap.com/assets/font/bootstrap-icons.min.css">
<link type="text/css" href="{{ url('assets/fonts/flaticon_quizzly_admin.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- fonts css -->
<link href="{{ url('admin_theme/assets/css/datatable/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('admin_theme/assets/css/datatable/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('admin_theme/assets/css/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('admin_theme/assets/css/datatable/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('admin_theme/vendor/slick/slick-theme.css')}}" rel="stylesheet" type="text/css">
<link href="{{ url('admin_theme/vendor/slick/slick.css')}}" rel="stylesheet" type="text/css"><!-- custom css -->
@if(in_array($language,$rtl))
<link href="{{ url('admin_theme/assets/css/style_rtl.css') }}" rel="stylesheet" type="text/css"/> <!-- custom rtl css -->
@else
<link href="{{ url('admin_theme/assets/css/style.css') }}" rel="stylesheet" type="text/css"/> <!-- custom css -->
<link href="{{ url('admin_theme/assets/css/style_dark.css') }}" rel="stylesheet" type="text/css"/> <!-- custom css -->
@endif
<link href="{{ url('admin_theme/vendor/select2/select2.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ url('admin_theme/assets/css/toastr.min.css') }}" rel="stylesheet" type="text/css"/> <!-- toastr css -->
<link href="{{ url('admin_theme/assets/css/froala_editor.min.css') }}" rel="stylesheet" type="text/css"/> <!-- custom css -->
<link href="{{ url('admin_theme/assets/css/froala_editor.pkgd.min.css') }}" rel="stylesheet" type="text/css"/> <!-- custom css -->
<link href="{{ url('admin_theme/assets/css/simplemde.min.css') }}" rel="stylesheet" type="text/css"/> <!-- custom css -->
<link rel="stylesheet" href="{{asset('admin_theme/assets/css/jodit.min.css')}}">
<link href="{{ asset('admin_theme/assets/css/intlTelInput.min.css') }}" rel="stylesheet" type="text/css">
{!! NoCaptcha::renderJs() !!}
<!-- end theme styles -->

@php
if(Schema::hasTable('admin_colors')){
  $colors = App\Models\AdminColor::first();
}
@endphp

@if(isset($colors))
<style type="text/css">
    :root {
        --bg_light_grey: {{ $colors['bg_light_grey'] }};
        --bg_white: {{ $colors['bg_white'] }};
        --bg_dark_blue: {{ $colors['bg_dark_blue'] }};
        --bg_dark_grey: {{ $colors['bg_dark_grey'] }};
        --bg_black: {{ $colors['bg_black'] }};
        --bg_yellow: {{ $colors['bg_yellow'] }};

        --text_black: {{ $colors['text_black'] }};
        --text_dark_grey: {{ $colors['text_dark_grey'] }};
        --text_light_grey: {{ $colors['text_light_grey'] }};
        --text_dark_blue: {{ $colors['text_dark_blue'] }};
        --text_white: {{ $colors['text_white'] }};
        --text_red: {{ $colors['text_red'] }};
        --text_yellow: {{ $colors['text_yellow'] }};

        --border_white: {{ $colors['border_white'] }};
        --border_black: {{ $colors['border_black'] }};
        --border_light_grey: {{ $colors['border_light_grey'] }};
        --border_dark_grey: {{ $colors['border_dark_grey'] }};
        --border_grey: {{ $colors['border_grey'] }};
        --border_dark_blue: {{ $colors['border_dark_blue'] }};
        --border_yellow: {{ $colors['border_yellow'] }};
    }
</style>

@else

<style type="text/css">
 :root {
    --bg_light_grey: #F1F1F1;
        --bg_white: #FFF;
        --bg_dark_blue: #131D5A;
        --bg_dark_grey: #E9E9EB;
        --bg_black: #000;
        --bg_yellow: #F99D30;

        --text_black: #000;
        --text_dark_grey: #747479;
        --text_light_grey: #F1F1F1;
        --text_dark_blue: #131D5A;
        --text_white: #FFF;
        --text_red: #E92B2B;
        --text_yellow: #F99D30;

        --border_white: #FFF;
        --border_black: #000;
        --border_light_grey: #F1F1F1;
        --border_dark_grey: #747479;
        --border_grey: #E9E9EB;
        --border_dark_blue: #131D5A;
        --border_yellow: #F99D30;
}
</style>
@endif
@yield('stylesheet')

