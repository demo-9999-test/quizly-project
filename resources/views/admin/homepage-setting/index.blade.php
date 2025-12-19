@extends('admin.layouts.master')
@section('title', 'Home page setting')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
    @slot('heading')
        {{ __('Homepage Setting') }}
    @endslot
    @slot('menu1')
        {{ __('Homepage Setting') }}
    @endslot
    @endcomponent
   
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block homesetting">
                    <div class="form-group">
                        <div class="row">
                            @foreach(['slider', 'counter', 'categories', 'friends', 'discover_quiz', 'battle', 'zone', 'testimonial', 'blogs', 'newsletter'] as $setting)
                            <div class="col-lg-3 home-setting-form">
                                    <label for="{{ $setting }}" class="form-label">{{ __(ucfirst(str_replace('_', ' ', $setting))) }}</label>
                                    <div class="form-check form-switch">
                                        <form action="{{ route('admin.home.setting.toggle') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="setting" value="{{ $setting }}">
                                            <input class="form-check-input" type="checkbox" role="switch" id="{{ $setting }}" name="{{ $setting }}" {{ $record->$setting ? 'checked' : '' }} onChange="this.form.submit()">
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
