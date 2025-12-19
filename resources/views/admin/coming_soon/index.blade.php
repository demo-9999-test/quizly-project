@extends('admin.layouts.master')
@section('title', 'Coming soon')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
        @slot('heading')
            {{ __('Coming soon') }}
        @endslot
        @slot('menu1')
            {{ __('Coming soon') }}
        @endslot
    @endcomponent

    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block">
                    <form action="{{ route('admin.coming_soon.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="image" class="form-label">{{ __('Background Image') }}<span class="required">*</span></label>
                                            <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image" accept="image/*">
                                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        @if($coming->image)
                                        <img src="{{ asset('images/coming_soon/' . $coming->image) }}" alt="{{__('Background Image')}}" class="img-fluid mt-2">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="heading" class="form-label">{{ __('Heading') }}<span class="required">*</span></label>
                                    <input class="form-control @error('heading') is-invalid @enderror" type="text" name="heading" id="heading" placeholder="{{ __('Enter Heading') }}" value="{{ old('heading', $coming->heading) }}">
                                    <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="btn_txt" class="form-label">{{ __('Button Text') }}<span class="required">*</span></label>
                                    <input class="form-control @error('btn_txt') is-invalid @enderror" type="text" name="btn_txt" id="btn_txt" placeholder="{{ __('Enter Button Text') }}" value="{{ old('btn_txt', $coming->btn_txt) }}">
                                    <div class="form-control-icon"><i class="flaticon-title"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="counter_one" class="form-label">{{ __('Counter One') }}<span class="required">*</span></label>
                                    <input class="form-control @error('counter_one') is-invalid @enderror" type="number" name="counter_one" id="counter_one" placeholder="{{ __('Enter Counter One') }}" value="{{ old('counter_one', $coming->counter_one) }}">
                                    <div class="form-control-icon"><i class="flaticon-record-button"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="counter_one_txt" class="form-label">{{ __('Counter One Text') }}<span class="required">*</span></label>
                                    <input class="form-control @error('counter_one_txt') is-invalid @enderror" type="text" name="counter_one_txt" id="counter_one_txt" placeholder="{{ __('Enter Counter One Text') }}" value="{{ old('counter_one_txt', $coming->counter_one_txt) }}">
                                    <div class="form-control-icon"><i class="flaticon-record-button"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="counter_two" class="form-label">{{ __('Counter Two') }}<span class="required">*</span></label>
                                    <input class="form-control @error('counter_two') is-invalid @enderror" type="number" name="counter_two" id="counter_two" placeholder="{{ __('Enter Counter Two') }}" value="{{ old('counter_two', $coming->counter_two) }}">
                                    <div class="form-control-icon"><i class="flaticon-record-button"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="counter_two_txt" class="form-label">{{ __('Counter Two Text') }}<span class="required">*</span></label>
                                    <input class="form-control @error('counter_two_txt') is-invalid @enderror" type="text" name="counter_two_txt" id="counter_two_txt" placeholder="{{ __('Enter Counter Two Text') }}" value="{{ old('counter_two_txt', $coming->counter_two_txt) }}">
                                    <div class="form-control-icon"><i class="flaticon-record-button"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="counter_three" class="form-label">{{ __('Counter Three') }}<span class="required">*</span></label>
                                    <input class="form-control @error('counter_three') is-invalid @enderror" type="number" name="counter_three" id="counter_three" placeholder="{{ __('Enter Counter Three') }}" value="{{ old('counter_three', $coming->counter_three) }}">
                                    <div class="form-control-icon"><i class="flaticon-record-button"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="counter_three_txt" class="form-label">{{ __('Counter Three Text') }}<span class="required">*</span></label>
                                    <input class="form-control @error('counter_three_txt') is-invalid @enderror" type="text" name="counter_three_txt" id="counter_three_txt" placeholder="{{ __('Enter Counter Three Text') }}" value="{{ old('counter_three_txt', $coming->counter_three_txt) }}">
                                    <div class="form-control-icon"><i class="flaticon-record-button"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="counter_four" class="form-label">{{ __('Counter Four') }}<span class="required">*</span></label>
                                    <input class="form-control @error('counter_four') is-invalid @enderror" type="number" name="counter_four" id="counter_four" placeholder="{{ __('Enter Counter Four') }}" value="{{ old('counter_four', $coming->counter_four) }}">
                                    <div class="form-control-icon"><i class="flaticon-record-button"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="counter_four_txt" class="form-label">{{ __('Counter Four Text') }}<span class="required">*</span></label>
                                    <input class="form-control @error('counter_four_txt') is-invalid @enderror" type="text" name="counter_four_txt" id="counter_four_txt" placeholder="{{ __('Enter Counter Four Text') }}" value="{{ old('counter_four_txt', $coming->counter_four_txt) }}">
                                    <div class="form-control-icon"><i class="flaticon-record-button"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="ip_address" class="form-label">{{ __('IP Address') }}</label>
                                    <input class="form-control @error('ip_address') is-invalid @enderror" type="text" name="ip_address" id="ip_address" placeholder="{{ __('Enter IP Address') }}" value="{{ old('ip_address', $coming->ip_address) }}">
                                    <div class="form-control-icon"><i class="flaticon-internet"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="maintenance_mode" class="form-label">{{ __('Maintenance Mode') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input @error('maintenance_mode') is-invalid @enderror" type="checkbox" role="switch" id="maintenance_mode" name="maintenance_mode" value="1" {{ $coming->maintenance_mode ? 'checked' : '' }}>
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
@endsection
