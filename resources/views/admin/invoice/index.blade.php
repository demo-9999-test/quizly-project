@extends('admin.layouts.master')
@section('title', 'Invoice Settings')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
            @slot('heading')
                {{ __('Invoice Settings') }}
            @endslot
            @slot('menu1')
                {{ __('Invoice Settings') }}
            @endslot
        @endcomponent

        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12">
                    <div class="client-detail-block">
                        <form action="{{ route('admin.invoice_settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row align-items-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="show_logo" class="form-label">{{ __('Show Logo') }}</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input @error('show_logo') is-invalid @enderror" type="checkbox" role="switch" id="show_logo" name="show_logo" value="1" {{ $settings->show_logo ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6" id="logoInputGroup">
                                            <div class="form-group">
                                                <label for="logo" class="form-label">{{ __('Logo') }}<span class="required">*</span></label>
                                                <input class="form-control" type="file" name="logo" id="logo" accept="image/*">
                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" id="logoPreviewWrapper">
                                            @if($settings->logo)
                                                <img id="logoPreview" src="{{ asset('images/invoice/logo/' . $settings->logo) }}" alt="{{__('Logo')}}" class="img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row align-items-center">
                                        <div class="col-lg-2">  
                                            <div class="form-group">
                                                <label for="show_signature" class="form-label">{{ __('Show Signature') }}</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input @error('show_signature') is-invalid @enderror" type="checkbox" role="switch" id="show_signature" name="show_signature" value="1" {{ $settings->show_signature ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6" id="signatureInputGroup">
                                            <div class="form-group">
                                                <label for="signature" class="form-label">{{ __('Signature') }}<span class="required">*</span></label>
                                                <input class="form-control" type="file" name="signature" id="signature" accept="image/*">
                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                            </div>
                                        </div>  
                                        <div class="col-lg-4" id="signaturePreviewWrapper">
                                            @if($settings->signature)
                                                <img id="signaturePreview" src="{{ asset('images/invoice/signature/' . $settings->signature) }}" alt="{{__('Signature')}}" class="img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="site_name" class="form-label">{{ __('Site Name') }}<span class="required">*</span></label>
                                        <input class="form-control @error('site_name') is-invalid @enderror" type="text" name="site_name" id="site_name" placeholder="{{ __('Enter Name Of Your Site') }}" aria-label="Site Name" value="{{ old('site_name', $settings->site_name) }}">
                                        <div class="form-control-icon"><i class="flaticon-speech-bubble-1"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="contact_address" class="form-label">{{ __('Contact Address') }}<span class="required">*</span></label>
                                        <input class="form-control @error('contact_address') is-invalid @enderror" type="text" name="contact_address" id="contact_address" placeholder="{{ __('Enter Your Address') }}" aria-label="Contact Address" value="{{ old('contact_address', $settings->contact_address) }}">
                                        <div class="form-control-icon"><i class="flaticon-speech-bubble-1"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="contact_email" class="form-label">{{ __('Contact Email') }}<span class="required">*</span></label>
                                        <input class="form-control @error('contact_email') is-invalid @enderror" type="email" name="contact_email" id="contact_email" placeholder="{{ __('Enter Your Email') }}" aria-label="Contact Email" value="{{ old('contact_email', $settings->contact_email) }}">
                                        <div class="form-control-icon"><i class="flaticon-speech-bubble-1"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="contact_phone" class="form-label">{{ __('Contact Phone') }}<span class="required">*</span></label>
                                        <input class="form-control @error('contact_phone') is-invalid @enderror" type="number" name="contact_phone" id="contact_phone" placeholder="{{ __('Enter Your Phone') }}" aria-label="contact_phone Email" value="{{ old('contact_phone', $settings->contact_phone) }}">
                                        <div class="form-control-icon"><i class="flaticon-speech-bubble-1"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="header_message" class="form-label">{{ __('Header Message') }}<span class="required">*</span></label>
                                        <textarea name="header_message" id="header_message" rows="4" class="form-control text-area-form">{{ old('header_message', $settings->header_message) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="footer_message" class="form-label">{{ __('Footer Message') }}<span class="required">*</span></label>
                                        <textarea name="footer_message" id="footer_message" class="form-control text-area-form" rows="4">{{ old('footer_message', $settings->footer_message) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" role="switch" id="status" name="status" value="1" {{ $settings->status ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <button type="submit" class="btn btn-primary">{{__('Save Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Toggle visibility script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoToggle = document.getElementById('show_logo');
        const signatureToggle = document.getElementById('show_signature');
    
        const logoInputGroup = document.getElementById('logoInputGroup');
        const logoPreviewWrapper = document.getElementById('logoPreviewWrapper');
    
        const signatureInputGroup = document.getElementById('signatureInputGroup');
        const signaturePreviewWrapper = document.getElementById('signaturePreviewWrapper');
    
        function toggleSection(toggle, inputGroup, previewWrapper) {
            if (toggle) {
                const visible = toggle.checked;
                inputGroup.style.display = visible ? 'block' : 'none';
                previewWrapper.style.display = visible ? 'block' : 'none';
            }
        }
    
        // Initial check on page load
        toggleSection(logoToggle, logoInputGroup, logoPreviewWrapper);
        toggleSection(signatureToggle, signatureInputGroup, signaturePreviewWrapper);
    
        // Event listeners
        logoToggle?.addEventListener('change', function () {
            toggleSection(logoToggle, logoInputGroup, logoPreviewWrapper);
        });

        signatureToggle?.addEventListener('change', function () {
            toggleSection(signatureToggle, signatureInputGroup, signaturePreviewWrapper);
        });
    });
</script>
@endsection
