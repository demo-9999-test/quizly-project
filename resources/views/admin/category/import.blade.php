@extends('admin.layouts.master')
@section('title', 'category Import')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Category') }}
    @endslot
    @slot('menu1')
    {{ __('Category') }}
    @endslot
    @slot('menu2')
    {{ __('Import') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('category.index') }}" title="{{__('Back')}}" class="btn btn-primary"><i class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar user-import-block">
        @include('admin.layouts.flash_msg')
                <div class="client-detail-block mb-4">
            <div class="row">
                <div class="col-lg-9 col-md-8">
                    <h5> {{ __('Import Category') }}</h5>
                </div>
                <div class="col-lg-3 col-md-4">
                    <a href="{{ route('category.export') }}" title="{{ __('Download Demo CSV') }}" class="btn btn-primary float-lg-end float-md-end float-sm-start">{{ __('Download Demo CSV') }}</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block">
                    <form action="{{ route('category.importSave') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <h5 class="block-heading"> {{ __('Import') }}</h5>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-5">
                                    <label for="" class="form-label"> {{ __('Select CSV File :') }}</label>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <input class="form-control" type="file" name="csv_file" accept=".csv" required>
                                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="user-import-submit-btn">
                                                <button type="submit" class="btn btn-primary">{{ __('Submit')
                                                    }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <!--  Table start-->
                        <table class="table data-table display nowrap" >
                            <thead>
                                <tr>
                                    <th>{{ __('Column No') }}</th>
                                    <th>{{ __(' Column Name') }}</th>
                                    <th>{{ __('Description') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><strong>{{ __('Category') }}</strong> (Required)</td>
                                    <td>{{ __('Category') }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><strong>{{ __('Subcategory') }}</strong> (Required)</td>
                                    <td>{{ __('Subcategory') }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><strong>{{ __('Childcategory') }}</strong> (Required)</td>
                                    <td>{{ __('Childcategory') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        {{-- --------- Table end-------------------------- --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
