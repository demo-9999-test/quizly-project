@extends('admin.layouts.master')
@section('title', 'Chat Settings')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Chat Settings ') }}
    @endslot
    @slot('menu1')
    {{ __('Project Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Chat Settings ') }}
    @endslot
    @endcomponent

    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!-- form code start -->
                <form action="{{ route('chat.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block mb-4">
                        <h5 class="block-heading"><i class="flaticon-whatsapp me-2"></i> {{ __(' WhatsApp Chat ') }}</h5>
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="header_title" class="form-label">{{ __('Header Title') }}</label>
                                    <input class="form-control" type="text" name="header_title"
                                        placeholder="{{ __('Please Enter Header Title') }}" aria-label="Heading"
                                        value="{{ $socialchat->header_title }}">
                                    <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-10 col-8">
                                            <label for="contact" class="form-label">{{ __('WhatsApp Phone No.')}}<span class="required"> *</span></label>
                                        </div>
                                        <div class="col-lg-4 col-md-2 col-4">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">{{ __('with country
                                                                code') }}</small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control form-control-lg" type="number" name="contact"
                                        placeholder="{{ __('Please Enter Phone Number') }}" aria-label="Phone Number"
                                        value="{{ $socialchat->contact }}" required>
                                    <div class="form-control-icon"><i class="flaticon-chat-1"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="wp_msg" class="form-label">{{ __('WhatsApp PopUp Msg') }}</label>
                                    <input class="form-control form-control-lg" type="text" name="wp_msg"
                                        placeholder="{{ __('Please Enter WhatsApp Message') }}"
                                        aria-label="WhatsApp Message" value="{{ $socialchat->wp_msg }}">
                                    <div class="form-control-icon"><i class="flaticon-phone-message"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="wp_color" class="form-label">{{ __('WhatsApp Color') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="wp_color" value="{{ $socialchat->wp_color }}"
                                            placeholder="{{ __('Please Enter Color') }}" aria-label="Color">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="welcome_status" class="form-label">{{ __('Button Position
                                            (Right/left)') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="welcome_status"
                                                name="button_position" value="1" {{ $socialchat->button_position == 1 ?'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="another_status" class="form-label">{{ __('WhatsApp Chat Button')
                                            }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="another_status"
                                                name="whatsapp_enable_button" value="1" {{
                                                $socialchat->whatsapp_enable_button == 1 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="client-detail-block">
                        <h5 class="block-heading"><i class="flaticon-facebook-1 me-2"></i>{{ __('Facebook Chat') }}
                        </h5>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <label for="facebook_chat_bubble" class="form-label">{{ __('Facebook Chat
                                                Bubble') }}</label>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">{{ __('Facebook Bubble
                                                                Chat will not work on localhost (e.g., xampp & wampp)')}}
                                                                <a href="https://app.respond.io/"
                                                                    class="recommended-font-size" title="{{ __('Get URL For
                                                                    Facebook Messenger Chat Bubble') }}">{{ __('Get URL For
                                                                    Facebook Messenger Chat Bubble') }}</a></small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control" type="url" name="facebook_chat_bubble"
                                        placeholder="https://app.respond.io/facebook/chat/plugin/XXXX/XXXXXXXXXX"
                                        aria-label="Heading" value="{{ $socialchat->facebook_chat_bubble }}">
                                    <div class="form-control-icon"><i class="flaticon-chat"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" title="{{ __('Submit') }}"><i
                            class="flaticon-upload-1"></i> {{ __('Submit') }}</button>
                </form>
                <!--form code end--->
            </div>
        </div>
    </div>
</div>

@endsection
