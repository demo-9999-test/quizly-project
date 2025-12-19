@extends('admin.layouts.master')
@section('title', 'State')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('State') }}
    @endslot
    @slot('menu1')
    {{ __('Project Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Locations') }}
    @endslot
    @slot('menu3')
    {{ __('State') }}
    @endslot
    @slot('button')
    <div class="col-md-6 col-lg-6">
        @can('packages_features.delete')
        <div class="widget-button">
            <a type="button" class="btn btn-primary " title="{{ __('Add State') }}" data-bs-toggle="modal"
                data-bs-target="#add_state"><i class="flaticon-plus"></i> {{ __('Add State') }}</a>
            <a type="button" class="btn btn-primary " data-bs-toggle="modal" title="{{ __('Add State Manual')
                }}" data-bs-target="#add_state_manual"><i class="flaticon-plus"></i> {{ __('Add State Manual')
                }}</a>
            <a type="button" class="btn btn-danger " title="{{ __('Delete') }}" data-bs-toggle="modal"
                data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent


    <div class="contentbar">
        @include('admin.layouts.flash_msg')
                <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block">
                    <div class="table-responsive">
                        <!-- table code start-->
                        <table class="table data-table display" id="example">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                    <th>{{ __('State Name') }}</th>
                                    <th>{{ __('Country Name') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <!----------- loop Print data show start ---------------- -->
                            <tbody id="sortable-table">
                                @if (isset($stateData))
                                @foreach ($stateData as $data)
                                <tr data-id="{{ $data->id }}">
                                    <td><input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input form-check-input'
                                            name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                    </td>
                                    <td>
                                        {{ $data->name }}
                                    </td>

                                    <td>
                                        {{ $data->country->nicename }}
                                    </td>

                                    <td>
                                        <div class="dropdown action-dropdown">
                                            <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="flaticon-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    @can('packages_features.delete')
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $data->id }}"
                                                        title="{{ __('Delete')}}"><i class="flaticon-delete"></i> {{
                                                        __('Delete')}}</a>
                                                    @endcan
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!------- -------------model Start ------------------->
                                <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                    {{ __('Are You Sure ?') }}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ __('Do you really want to delete') }} ?
                                                    {{ __('This process cannot be undone.') }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post"
                                                    action="{{ url('admin/state/' . $data->id . '/delete') }}"
                                                    class="pull-right">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="reset" class="btn btn-secondary"
                                                        title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No')
                                                        }}</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        title="{{ __('Yes') }}">{{ __('Yes')
                                                        }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---- model end --->
                                @endforeach
                                <!-- loop  Print data show end-->
                                @endif
                            </tbody>
                        </table>
                        <!-- table code end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- add state Modal start -->
<div class="modal fade" id="add_state" tabindex="-1" aria-labelledby="bulkDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bulkDeleteLabel">{{ __('States') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" title="{{ __('Close') }}"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('state.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group search-select">
                        <label for="country" class="form-label">{{ __('States') }}</label> <span
                            class="required">*</span>
                        <select class="form-select" name="country_id" required>
                            <option disabled selected>{{ __('Choose Country') }}</option>
                            @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->nicename }}</option>
                            @endforeach
                        </select>
                        <div class="form-control-icon"><i class="flaticon-task"></i></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{
                        __('No') }}</button>
                    <form id="bulk_delete_form" method="post" action="{{ route('country.bulk_delete') }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-primary" title="{{ __('Yes') }}">{{ __('Yes') }}</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- add state Modal end -->

<!-- add state manual Modal start -->
<div class="modal fade" id="add_state_manual" tabindex="-1" aria-labelledby="bulkDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bulkDeleteLabel">{{ __('Add State Manual') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" title="{{ __('Close') }}"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('state.manual') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group search-select">
                        <label for="country" class="form-label">{{ __('Country') }}</label> <span
                            class="required">*</span>
                        <select class="form-select" name="country_id" required>
                            <option disabled selected>{{ __('Choose Country') }}</option>
                            @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->nicename }}</option>
                            @endforeach
                        </select>
                        <div class="form-control-icon"><i class="flaticon-task"></i></div>
                    </div>

                    <div class="form-group">
                        <label for="State" class="form-label">{{ __('State') }}<span class="required">
                                *</span></label>
                        <input class="form-control" type="text" name="name" required
                            placeholder="{{ __('Enter State Name') }}" aria-label="State" value="{{ old('name') }}">
                        <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{
                        __('No') }}</button>
                    <form id="bulk_delete_form" method="post" action="{{ route('country.bulk_delete') }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-primary" title="{{ __('Yes') }}">{{ __('Yes') }}</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- add state manual Modal end -->

<!-- Bulk Delete Modal start -->
<div class="modal fade" id="bulk_delete" tabindex="-1" aria-labelledby="bulkDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bulkDeleteLabel">{{ __('Delete Selected Records') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" title="{{ __('Close') }}"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Do you really want to delete the selected records? This action cannot be undone.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{
                    __('No') }}</button>
                <form id="bulk_delete_form" method="post" action="{{ route('state.bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-primary" title="{{ __('Yes') }}">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bulk Delete Modal end -->

@endsection
