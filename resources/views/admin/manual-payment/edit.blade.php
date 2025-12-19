@extends('admin.layouts.master')
@section('title', 'Edit Manual Payment Gateway')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['thirdactive' => 'active'])
            @slot('heading')
                {{ __('Edit Manual Payment Gateway') }}
            @endslot
            @slot('menu1')
                {{ __('Payment Gateway') }}
            @endslot
            @slot('menu2')
                {{ __('Edit Manual Payment Gateway') }}
            @endslot
            @slot('button')

                <div class="col-md-6 col-lg-6">
                    <div class="widget-button">
                        <a href="{{ route('manual.show') }}" class="btn btn-primary"><i class="flaticon-back"
                                title="{{ __('Back') }}"></i>{{ __('Back') }}</a>
                    </div>
                </div>
            @endslot
        @endcomponent

        <div class="contentbar profile-main-block">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form start -->
                    <form action="{{ route('manual.update', $payment->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="client-detail-block">
                            <h5 class="block-heading">Personal Details</h5>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label for="gateway_name" class="form-label">{{ __('Gateway Name') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control @error('gateway_name') is-invalid @enderror" type="text"
                                            name="gateway_name" id="gateway_name" placeholder="{{ __('Please Enter Your Gateway Name') }}"
                                            aria-label="Name" value="{{ old('gateway_name', $payment->gateway_name) }}" required>
                                        <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                        @error('gateway_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label for="logo" class="form-label">{{ __('Logo') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control @error('logo') is-invalid @enderror" type="file"
                                            name="logo" id="logo" accept="image/*" onchange="previewImage(event)">
                                        <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        @error('logo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <img id="preview" src="{{ asset($payment->logo_url) }}" alt="{{__('Preview Image')}}"
                                            style="max-width:100px; max-height:100px; margin-top:10px;">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="details" class="form-label">{{ __('Details') }}</label>
                                        <textarea class="form-control form-control-padding_15" name="details" rows="2" id="desc"
                                            placeholder="{{ __('Please Enter Your Details') }}">{{ old('details', $payment->details) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                                name="status" value="1" {{ $payment->status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" title="{{ __('Update') }}" class="btn btn-primary"><i
                                class="flaticon-upload-1"></i> {{ __('Update') }}</button>
                    </form>
                    <!-- Form end -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush
