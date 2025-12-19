@extends('admin.layouts.master')
@section('title', __('Remove Public'))
@section('main-container')
<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
        @slot('heading')
            {{ __('Remove Public') }}
        @endslot
        @slot('menu1')
            {{ __('Help & Support') }}
        @endslot
        @slot('menu2')
            {{ __('Remove Public') }}
        @endslot
    @endcomponent

    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block">
                    <div class="card-importnat-note">
                        <div class="col-lg-12">
                            <small class="text-success process-fonts"><i class="flaticon-info me-2"></i>
                                {{ __('Important Note') }}
                                <ul class="pwa-text-widget">
                                    <li>
                                        {{ __('Removing public from URL only works when you have installed the script in the main domain.') }}
                                    </li>
                                    <li>
                                        {{ __('Do not remove public when you have installed the script in subdomain or subfolders.') }}
                                    </li>
                                    <li>
                                        {{ __('Removing public from URL does not work for Localhost.') }}
                                    </li>
                                </ul>
                            </small>
                        </div>
                    </div>

                    @php
                        $htaccessExists = file_exists(base_path().'/.htaccess');
                        $contentsMatch = isset($contents) && isset($destinationPath) && $contents == $destinationPath;
                    @endphp

                    @if($htaccessExists)
                        @if(!$contentsMatch)
                            <form action="{{ route('removepublic.add') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="client-detail-block">
                                    <button type="submit" title="{{ __('Click to Remove Public') }}" class="btn btn-primary mt-3">
                                        {{ __('Click to Remove Public') }}
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-info mt-3">
                                {{ __('Public has already been removed from the URL.') }}
                            </div>
                        @endif
                    @else
                        <form action="{{ route('removepublic.create') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <button type="submit" title="{{ __('Click to Remove Public') }}" class="btn btn-primary mt-3">
                                {{ __('Click to Remove Public') }}
                            </button>
                        </form>
                    @endif

                    <div class="card-note mt-3">
                        <div class="col-lg-12">
                            <small class="process-fonts"><i class="flaticon-info me-2"></i>
                                {{ __('Remove Public From URL Manually') }}
                                <ul class="pwa-text-widget">
                                    <li>
                                        {{ __('To remove the public from the URL create a .htaccess file in the root
                                        folder and write following code.') }}
                                    </li>
                                    <pre>
{{ __('<IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteRule ^(.*)$ public/$1 [L]
    </IfModule>') }}
                                                </pre>
                                    <li>
                                        {{ __('To remove the public from URL and Force HTTPS redirection create a
                                        .htaccess file in the root folder and write the following code.') }}
                                    </li>
                                    <pre>
{{ __(' <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{HTTPS} !=on
        RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301,NE]
        RewriteRule ^(.*)$ public/$1 [L]
    </IfModule>') }}
                                                </pre>
                                </ul>
                            </small>
                        </div>
                    </div>
                    <!-- Debug Information -->
                    @if(config('app.debug'))
                        <div class="card mt-3">
                            <div class="card-header">Debug Information</div>
                            <div class="card-body">
                                <p>htaccess exists: {{ $htaccessExists ? 'Yes' : 'No' }}</p>
                                <p>Contents match: {{ $contentsMatch ? 'Yes' : 'No' }}</p>
                                @if(isset($contents))
                                    <p>Contents: {{ $contents }}</p>
                                @else
                                    <p>Contents variable is not set</p>
                                @endif
                                @if(isset($destinationPath))
                                    <p>Destination Path: {{ $destinationPath }}</p>
                                @else
                                    <p>Destination Path variable is not set</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
