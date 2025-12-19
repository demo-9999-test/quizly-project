@extends('admin.layouts.master')
@section('title', 'Packages ')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Packages ') }}
    @endslot
    @slot('menu1')
    {{ __('Packages ') }}
    @endslot
    @slot('menu2')
    {{ __('Packages ') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('packages.show') }}" title="{{ __('Back') }}" class="btn btn-primary"><i
                    class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
                <div class="row">
            <div class="col-lg-12">
                <form action="{{ url('admin/packages/' . $package->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="client-detail-block">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-label">{{ __('Plan Unique ID') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control" type="text" name="plan_id" id=""
                                        placeholder="{{ __('Please Enter Your Plan Unique ID') }}" aria-label=""
                                        required value="{{ $package->plan_id }}">
                                    <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-label">{{ __('Package Name') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control" type="text" name="pname" id=""
                                        placeholder="{{ __('Please Enter Your Package Name') }}" aria-label="" required
                                        value="{{ $package->pname }}">
                                    <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="Title" class="form-label">{{ __('Package Feature') }}<span
                                            class="required">*</span></label>
                                    <select class="form-select select2-multi-select" name="pfeatures_id[]"
                                        multiple="multiple">

                                        @foreach ($pfeatures as $data)
                                        @php
                                        $selected = in_array($data->id, explode(',', $package->pfeatures_id)) ?
                                        'selected' : '';

                                        @endphp
                                        <option {{ $selected }} value="{{ $data->id }}">
                                            {{ $data->title }}</option>
                                        @endforeach
                                        
                                    </select>
                                    <div class="form-control-icon"><i class="flaticon-features"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="col-lg-9 col-md-9">
                                        <div id="plan-amount-section">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="plan_amount" class="form-label">{{ __('Plan Price')
                                                            }}<span class="required">*</span></label>
                                                        <input class="form-control form-control-lg" type="number"
                                                            name="plan_amount" id="plan_amount" placeholder="0.00"
                                                            aria-label="title" min="0"
                                                            value="{{ $package->plan_amount }}">
                                                        <div class="form-control-icon"><i class="flaticon-gross"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="preward" class="form-label">{{ __('Package reward') }}<span
                                                                class="required">*</span></label>
                                                        <input class="form-control" type="number" name="preward" id="preward"
                                                            placeholder="{{ __('Coin') }}" aria-label="" required
                                                            value="{{ $package->preward }}">
                                                        <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">{{ __('Status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" name="status"
                                            value="1" {{ $package->status == 1 ? 'checked' :
                                        '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" title="{{ __('Submit') }}"><i
                            class="flaticon-upload-1"></i>{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

