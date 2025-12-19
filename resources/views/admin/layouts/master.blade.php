<!DOCTYPE html>
<?php
$seo = \App\Models\SeoSetting::first();
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of rtl languages
?>
@stack('styles')


@if(in_array($language,$rtl))
<html lang="ar" dir="rtl">
@else
<html lang="en">
@endif

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    @php
        $settings = \App\Models\Setting::first();
    @endphp
    @if (!empty($settings->favicon_logo))
        <link rel="icon" type="image/png" href="{{ asset('images/favicon/' . $settings->favicon_logo) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/favicon/default.png') }}">
    @endif
    @if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    <!-- <title>@yield('title') | {{ __('Admin') }}</title> -->
    <title>@yield('title')</title>
    @include('admin.layouts.header')
</head>

<body class="vertical-layout app">
    <script>
        (function() {
            var isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                document.documentElement.classList.add('is-collapsed');
            }
        })();
    </script>
    <script>
        (function() {
          if (localStorage.getItem("darkMode") === "enabled") {
            document.documentElement.classList.add("dark-mode");
            document.body.style.backgroundColor = "#000"; // Set to your dark background color
          }
        })();
    </script>
    @include('admin.layouts.flash_msg')

    @php
    $setting = \App\Models\Setting::first();
    $gsetting = \App\Models\GeneralSetting::first();
    @endphp

    <div class="leftbar">
        <div class="sidebar position-fixed top-0 bottom-0 border-end">
            <div class="sidebar-logo p-3">
                <div class="logo-lg">
                    <a href="{{ url('admin/dashboard') }}" title="{{ __('logo') }}">
                        <img src="{{ asset('images/admin_logo/' . ($setting->admin_logo ?? 'default.png')) }}" 
                             alt="{{ __('logo') }}" class="img-fluid" id="logo"> {{-- ✅ Changed --}}
                    </a>
                </div>
                <div class="logo-sm">
                    <a href="{{ url('admin/dashboard') }}" title="{{ __('logo') }}">
                        <img src="{{ asset('images/favicon/' . ($gsetting->favicon_logo ?? '1717397765.png')) }}" 
                             alt="{{ __('logo') }}" class="img-fluid" id="logo"> {{-- ✅ Changed --}}
                    </a>
                </div>
            </div>
            @include('admin.layouts.sidebar')
        </div>
    </div>

    <div class="rightbar">
        <div class="menubar-smallscreen">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-2">
                        <div class="menubar-content-left">
                            <div class="hamburger-menu">
                                <span onclick="openNav()" class="hamburger">&#9776; </span>
                                <div id="mySidenav" class="sidenav">
                                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                                    @include('admin.layouts.msidebar')
                                </div>
                            </div>
                            <div class="sidebar-logo py-3">
                                <a href="#" title="{{ __('logo') }}">
                                    @if(isset($setting->favicon_logo) && !empty($setting->favicon_logo))
                                        <img src="{{ asset('images/favicon/' . $setting->favicon_logo) }}" alt="Favicon Logo">
                                    @endif
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-10">
                        <div class="menubar-content-right">
                            <div class="infobar">
                                <ul class="topbar-options">
                                    <li>
                                        <div class="visit-site-icon">
                                            <a href="{{route('home.page')}}" target="_blank" title="{{ __('Visit Site')}}"><i
                                                    class="flaticon-external-link"></i></a>
                                        </div>
                                    </li>
                                    <li>
                                        @php
                                        $language = App\Models\LanguageSetting::all();
                                        $defaultlang = App\Models\LanguageSetting::where('status', 1)->first();
                                        @endphp
                                        <div class="dropdown">
                                            <a href="#" id="dropdownToggle" class="btn dropdown-toggle" title="language" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                @if(isset($defaultlang))
                                                    <img id="selectedFlag" src="{{ asset('/images/language/' . $defaultlang->image) }}" class="img-fluid" alt="{{ __('default') }}">
                                                @endif
                                            </a>
                                            <ul class="dropdown-menu">
                                                @foreach ($language as $data)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('languageSwitch', [$data->local, $data->image]) }}"
                                                        onclick="selectLanguage('/{{ $data->image }}')">
                                                        <img src="{{ asset('/images/language/' . $data->image) }}" class="img-fluid"
                                                            alt="{{ $data->name }}">
                                                        {{ $data->name }} ({{ $data->local }})
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        @php
                                        $currencies = DB::table('currencies')->get();
                                        $defautcurrency = DB::table('currencies')->where('default' , 1)->first();
                                        @endphp
                                        <div class="dropdown">
                                            <a class="language dropdown-toggle" href="javascript:void(0)" title="currency"
                                                data-bs-toggle="dropdown" aria-expanded="true">
                                                {{ $defautcurrency->symbol }}
                                            </a>
                                            <ul class="dropdown-menu">
                                                @foreach ($currencies as $data)
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('currencySwitch', $data->symbol) }}">
                                                        {{ $data->code }} ({{ $data->symbol }})
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="dark-light-mode">
                                        <div class="toggle-container">
                                            <a href="#" id="modeSwitch" onclick="toggleMode()" title="dark theme">
                                                <i class="modeIcon flaticon-sun-1" id="modeIcon"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown">
                                            <a class="btn dropdown-toggle" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                                    class="flaticon-user"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ url('admin/profile') }}"
                                                        title="My Account"><i class="fa-solid fa-user"></i>{{ __('My Account') }} </a></li>
                                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                                        title="Logout">
                                                    <i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.layouts.topbar')
        @yield('main-container')
    </div>

    @include('admin.layouts.footer')
    @include('admin.layouts.script')
    @yield('scripts')
    @stack('scripts')
</body>
</html>
