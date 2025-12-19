@extends('admin.layouts.master')
@section('title', 'Color Setting')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Color Settings') }}
    @endslot
    @slot('menu1')
    {{ __('Admin Panel') }}
    @endslot
    @slot('menu2')
    {{ __('Color Settings') }}
    @endslot
    @endcomponent

    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!-- form code start -->
                 <form action="{{ route('admincolor.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="row mt-3">
                            <h5 class="block-heading">{{ __('Background Colors') }} </h5>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('Light Grey') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="bg_light_grey" value="{{ $color->bg_light_grey }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('White ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="bg_white" value="{{ $color->bg_white }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('Dark Blue ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="bg_dark_blue" value="{{ $color->bg_dark_blue }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('Dark Grey ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="bg_dark_grey" value="{{ $color->bg_dark_grey }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('Black ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="bg_black" value="{{ $color->bg_black }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('Yellow ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="bg_yellow" value="{{ $color->bg_yellow }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="client-detail-block mt-3">
                        <div class="row mt-3">
                            <h5 class="block-heading">{{ __('Text Colors') }}</h5>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' Black') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="text_black" value="{{ $color->text_black }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' Dark Grey') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="text_dark_grey" value="{{ $color->text_dark_grey }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' Light Grey ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="text_light_grey"
                                        value="{{ $color->text_light_grey }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' Dark Blue ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="text_dark_blue" value="{{ $color->text_dark_blue }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' white ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="text_white" value="{{ $color->text_white }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' Red ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="text_red" value="{{ $color->text_red }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' Yellow ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="text_yellow" value="{{ $color->text_yellow }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="client-detail-block mt-3">
                        <div class="row mt-3">
                            <h5 class="block-heading">{{ __('Border Colors') }}</h5>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('White') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="border_white" value="{{ $color->border_white }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('Black') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="border_black" value="{{ $color->border_black }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' Light Grey ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="border_light_grey"
                                        value="{{ $color->border_light_grey }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' Dark Grey ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="border_dark_grey"
                                            value="{{ $color->border_dark_grey }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' Grey ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="border_grey" value="{{ $color->border_grey }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' Dark Blue ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="border_dark_blue"
                                            value="{{ $color->border_dark_blue }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __(' Yellow ') }}</label>
                                    <div class="form-control">
                                        <input type="color" name="border_yellow" value="{{ $color->border_yellow }}">
                                        <div class="form-control-icon"><i class="flaticon-colour"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admincolor.reset') }}" class="btn btn-secondary mt-3" title="{{ __('Reset') }}"><i
                    class="flaticon-refresh"></i>{{ __("Reset")}}</a>
                    <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary mt-3"><i
                    class="flaticon-upload-1"></i> {{__('Submit')}}</button>
                </form>
                <!--form code end -->
            </div>
        </div>
    </div>
</div>
@endsection
