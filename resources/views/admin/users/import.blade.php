@extends('admin.layouts.master')
@section('title', 'Users Import')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Users ') }}
    @endslot
    @slot('menu1')
    {{ __('Users ') }}
    @endslot
    @slot('menu2')
    {{ __('Import ') }}
    @endslot

    @slot('button')
    <div class="col-md-7 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('users.show') }}" class="btn btn-primary"><i class="flaticon-back"
                    title="{{ __('Back') }}"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent

    <div class="contentbar user-import-block">
        @include('admin.layouts.flash_msg')
                <div class="client-detail-block mb-4">
            <div class="row">
                <div class="col-lg-9 col-md-8">
                    <h5> {{ __('Import Users') }}</h5>
                </div>
                <div class="col-lg-3 col-md-4">
                    <button onclick="downloadCSV()" class="btn btn-primary float-lg-end float-md-end float-sm-start"
                        title=" {{ __('Download Demo CSV') }}">
                        {{ __('Download Demo CSV') }}
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block">
                    <form action="{{ route('users.importSave') }}" method="post" enctype="multipart/form-data">
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
                                            <input class="form-control" type="file" name="file" accept=".csv" required>
                                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="user-import-submit-btn">
                                                <button type="submit" title=" {{ __('Submit') }}"
                                                    class="btn btn-primary">{{ __('Submit') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <!--  Table start-->
                        <table class="table data-table display nowrap" id="example">
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
                                    <td><strong>{{ __('Name') }}</strong> (Required)</td>
                                    <td>{{ __('Name') }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><strong>{{ __('Mobile') }}</strong> (Required)</td>
                                    <td>{{ __('Mobile') }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><strong>{{ __('Email') }}</strong> (Required)</td>
                                    <td>{{ __('Email') }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><strong>{{ __('Gender') }}</strong> (Required)</td>
                                    <td> {{ __('Gender') }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><strong>{{ __('Address') }}</strong> (Required)</td>
                                    <td>{{ __('Address') }}</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td><strong> {{ __('Status') }}</strong> (Required)</td>
                                    <td> {{ __('Status') }}</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td><strong> {{ __('Role') }}</strong> (Required)</td>
                                    <td> {{ __('Role') }}</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td><strong> {{ __('Image') }}</strong> (Required)</td>
                                    <td> {{ __('Image') }}</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td><strong> {{ __('Password') }}</strong> (Required)</td>
                                    <td>{{ __('Password') }}</td>
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
