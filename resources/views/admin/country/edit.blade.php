@extends('admin.layouts.master')
@section('title', 'Edit Country')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fifthactive' => 'active'])
    @slot('heading')
    {{ __('Country') }}
    @endslot
    @slot('menu1')
    {{ __('Project Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Locations') }}
    @endslot
    @slot('menu3')
    {{ __('Country') }}
    @endslot
    @slot('menu4')
    {{ __('Edit') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('country.show') }}" title="{{__('Back')}}" class="btn btn-primary"><i class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-4">
                <form action="{{ route('country.update', $countryData->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="client-detail-block">
                        <div class="form-group search-select">
                            <label for="country" class="form-label">{{ __('Country') }} <span class="required">*</span></label>
                            <select class="select select2-single form-control" name="country" required>
                                <option disabled>{{ __('Choose Country') }}</option>
                                @foreach ($country as $countryItem)
                                    <option value="{{ $countryItem->id }}" {{ ($countryItem->id == $countryData->country_id) ? 'selected' : '' }}>
                                        {{ $countryItem->nicename }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-control-icon"><i class="flaticon-task"></i></div>
                        </div>
                        <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary mt-3">
                            <i class="flaticon-upload-1"></i> {{ __('Submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
