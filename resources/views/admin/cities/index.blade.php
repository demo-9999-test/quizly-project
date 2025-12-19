@extends('admin.layouts.master')
@section('title', 'City')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('City') }}
    @endslot
    @slot('menu1')
    {{ __('Project Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Locations') }}
    @endslot
    @slot('menu3')
    {{ __('City') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a type="button" class="btn btn-primary " title="{{ __('Add State') }}" data-bs-toggle="modal"
                data-bs-target="#add_state"><i class="flaticon-plus"></i> {{ __('Add State') }}</a>
            <a type="button" class="btn btn-primary " data-bs-toggle="modal" title="{{ __('Add State Manual') }}"
                data-bs-target="#add_state_manual"><i class="flaticon-plus"></i> {{ __('Add State Manual')
                }}</a>
            <a type="button" title="{{ __('Delete') }}" class="btn btn-danger " data-bs-toggle="modal"
                data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="client-detail-block">
                            <div class="table-responsive">
                                <!-- Yajra DataTable Syntax -->
                                <table class="table data-table display" id="cities-table" data-ajax-url="{{ route('getCitiesData') }}">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                        <th>{{ __('City') }}</th>
                                        <th>{{ __('State') }}</th>
                                        <th>{{ __('Country') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody> <!-- DataTable will populate this -->
                                </table>
                        <!-- End Yajra DataTable Syntax -->
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('cities.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group search-select">
                        <label for="country" class="form-label">{{ __('State') }}</label> <span
                            class="required">*</span>
                        <select class="form-select" name="state_id" required>
                            <option disabled selected>{{ __('Choose State') }}</option>
                            @foreach ($allstates as $states)
                            <option value="{{ $states->state_id }}">{{ $states->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-control-icon"><i class="flaticon-task"></i></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No') }}</button>
                    <form id="bulk_delete_form" method="post" action="{{ route('country.bulk_delete') }}">
                        @csrf
                        @method('POST')
                        <button type="submit" title="{{ __('Yes') }}" class="btn btn-primary">{{ __('Yes') }}</button>
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
                <button type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('cities.manual') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group search-select">
                        <label for="country" class="form-label">{{ __('State') }}</label> <span
                            class="required">*</span>
                            <select class="form-select" name="state_id" required>
                                <option disabled selected>{{ __('Choose State') }}</option>
                                @foreach ($allstates as $states)
                                <option value="{{ $states->state_id }}">{{ $states->name }}</option>
                                @endforeach
                            </select>
                        <div class="form-control-icon"><i class="flaticon-task"></i></div>
                    </div>
                    <div class="form-group">
                        <label for="State" class="form-label">{{ __('City ') }}<span class="required"> *</span></label>
                        <input class="form-control" type="text" name="name" required
                            placeholder="{{ __('Enter City Name') }}" aria-label="State"
                            value="{{ old('name') }}">
                        <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No') }}</button>
                    <form id="bulk_delete_form" method="post" action="{{ route('country.bulk_delete') }}">
                        @csrf
                        @method('POST')
                        <button type="submit" title="{{ __('Yes') }}" class="btn btn-primary">{{ __('Yes') }}</button>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Do you really want to delete the selected records? This action cannot be undone.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No') }}</button>
                <form id="bulk_delete_form"  method="post" action="{{ route('cities.bulk_delete') }}">
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
@section('scripts')
<script src="{{ asset('admin_theme/assets/js/cities-table.js') }}"></script>
@endsection
