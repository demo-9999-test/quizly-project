@extends('admin.layouts.master')
@section('title', 'Country')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
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
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a type="button" class="btn btn-danger" title="{{__('Delete')}}" data-bs-toggle="modal" data-bs-target="#bulk_delete"><i
                    class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <form action="{{ route('country.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block mb-4">
                        <div class="form-group search-select">
                            <label for="country" class="form-label">{{ __('Country') }} <span
                                    class="required">*</span></label>
                            <select class="select select2-single form-control" name="country" required>
                                <option disabled selected>{{ __('Choose Country') }}</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->nicename }}</option>
                                @endforeach
                            </select>
                            <div class="form-control-icon"><i class="flaticon-task"></i></div>
                        </div>
                        <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary mt-3"><i
                                class="flaticon-upload-1"></i> {{__('Submit') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="client-detail-block">
                    <div class="table-responsive">
                        <!-- table code start-->
                        <table class="table data-table" id="data-table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                    <th>{{ __('Country Name') }}</th>
                                    <th>{{ __('ISO Code 2') }}</th>
                                    <th>{{ __('ISO Code 3') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <!----------- loop Print data show start ---------------- -->
                            <tbody id="sortable-table">
                                @if (isset($countryData))
                                @foreach ($countryData as $data)
                                <tr data-id="{{ $data->id }}">
                                    <td><input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input form-check-input'
                                            name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                    </td>
                                    <td>
                                        {{ $data->name }}
                                    </td>
                                    <td>
                                        {{ $data->iso }}
                                    </td>
                                    <td>
                                        {{ $data->iso3 }}
                                    </td>
                                    <td>
                                        <div class="dropdown action-dropdown">
                                            <a class="dropdown-toggle"  href="#" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="flaticon-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    @can('packages_features.edit')
                                                    <a href="{{ url('admin/country/' . $data->id . '/edit') }}"
                                                        class="dropdown-item" title="{{ __('Edit')}}">
                                                        <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                    </a>
                                                    @endcan
                                                </li>
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
                                                    action="{{ url('admin/country/' . $data->id . '/delete') }}"
                                                    class="pull-right">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="reset" class="btn btn-secondary"
                                                        title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No')
                                                        }}</button>
                                                    <button type="submit" title="{{ __('Yes') }}"
                                                        class="btn btn-primary">{{ __('Yes')
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
<!-- Bulk Delete Modal start -->
<div class="modal fade" id="bulk_delete" tabindex="-1" aria-labelledby="bulkDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bulkDeleteLabel">{{ __('Delete Selected Records') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Do you really want to delete the selected records? This action cannot be undone.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{
                    __('No') }}</button>
                <form id="bulk_delete_form" method="post" action="{{ route('country.bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="submit" title="{{ __('Yes') }}" class="btn btn-primary">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bulk Delete Modal end -->

@endsection

