@extends('admin.layouts.master')
@section('title', 'Database Backup')
@section('main-container')
<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Database Backup') }}
    @endslot
    @slot('menu1')
    {{ __('Help & Support') }}
    @endslot
    @slot('menu2')
    {{ __('Database Backup') }}
    @endslot
    @endcomponent
    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block">
                    <h5 class="block-heading"> {{ __('Database Backup Manager') }}</h5>
                    <div class="database-backup-form">
                        <div class="row">
                            <!-- form code start --->
                            <form action="{{ route('databaseupdate') }}" method="POST">
                                @csrf
                                <div class="col-lg-6 col-md-6">
                                    <label for="">{{ __('MySQL Dump Path') }}:</label>
                                    <div class="form-group">
                                        <input class="form-control" type="password" name="DUMP_BINARY_PATH" id="title"
                                            placeholder="/usr/bin/mysql/mysql-5.7.24-winx64/bin" aria-label="title">
                                        <div class="form-control-icon form-control-icon-one"><i
                                                class="flaticon-database"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <button type="submit" class="btn btn-primary" title="{{ __('Save') }}"><i
                                            class="flaticon-save me-2"></i>{{ __('Save') }}</button>
                                </div>
                            </form>
                            <!--form code end-->
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-6 col-md-6">
                            <div class="card-importnat-note mb-4">
                                <div class="col-lg-12">
                                    <small class="text-success process-fonts"><i class="flaticon-info me-2"></i>
                                        {{ __('Important Note') }}
                                        <ul class="pwa-text-widget">
                                            <li>
                                                {{ __('Usually in all hosting dump path for MYSQL is /user/bin') }}
                                            </li>
                                            <li>
                                                {{ __('If that path not work than contact your hosting provider with
                                                subject "What is my MYSQL DUMP Binary path ?') }}
                                            </li>
                                            <li>
                                                {{ __('Enter the path without mysqldump in path') }}
                                            </li>

                                        </ul>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="card-note">
                                <div class="col-lg-12">
                                    <small class="process-fonts"><i class="flaticon-info me-2"></i>
                                        {{ __('Note') }}
                                        <ul class="pwa-text-widget">
                                            <li>
                                                {{ __('It will generate only database backup of your site.') }}
                                            </li>
                                            <li>
                                                {{ __('Download URL is valid only for 1 (minute)') }}
                                            </li>
                                            <li>
                                                {{ __('Make sure mysql dump is enabled on your server for database
                                                backup and before run this or run only database backup command make
                                                sure you save the mysql dump path in config/database.php') }}
                                            </li>

                                        </ul>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <a @if(env('DUMP_BINARY_PATH') !='' ) href="{{ route('database.genrate') }}" @else href="#"
                            disabled @endif title="{{ __('Generate Database Backup') }}" class="btn btn-primary mt-4">{{
                            __('Generate Database Backup') }}</a>
                        </div>
                        <div class="col-lg-6 mt-4">
                            <div >
                                <p class="text-success"> <b>{{__('Download the latest backup')}}</b> </p>
                                @php
                                $dir17 = storage_path() . '/app/'.config('app.name');
                                @endphp
                                <ul>
                                    @foreach (array_reverse(glob("$dir17/*")) as $key=> $file)
                                    @if($loop->first)
                                    <li><a
                                            href="{{ URL::temporarySignedRoute('database.download', now()->addMinutes(1), ['filename' => basename($file)]) }}"><b>{{ basename($file)  }}
                                                (Latest)</b></a></li>
                                    @else
                                    <li><a href="<a href="
                                            {{ URL::temporarySignedRoute('database.download', now()->addMinutes(1), ['filename' => basename($file)]) }}">{{ basename($file)  }}</a>
                                    </li>
                                    @endif
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>
@endsection
