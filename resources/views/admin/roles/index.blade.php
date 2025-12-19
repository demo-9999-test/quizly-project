@extends('admin.layouts.master')
@section('title', 'Roles & Permissions')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb',['thirdactive' => 'active'])
            @slot('heading')
                {{ __('Roles & Permissions ') }}
            @endslot
            @slot('menu1')
                {{ __('Roles & Permissions') }}
            @endslot
            @slot('button')

                <div class=" col-md-6 col-lg-6">
                    <div class="widget-button">
                        <a href="{{ route('roles.create') }}" title="{{ __('Add') }}" class="btn btn-primary "><i
                                class="flaticon-plus"></i>{{ __('Add') }}</a>
                        @can('roles.delete')
                            <a type="button" class="btn btn-danger" title="{{ __('Delete') }}" data-bs-toggle="modal"
                            data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
                        @endcan
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
                            <!-- Table start -->
                            <table class="table data-table display nowrap" id="example">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('Role Name') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($roles))
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @foreach ($roles->sortBy('name') as $role)
                                            <tr>
                                                <td><input type='checkbox' form='bulk_delete_form'
                                                        class='check filled-in material-checkbox-input form-check-input'
                                                        name='checked[]' value="{{ $role->id }}"
                                                        id='checkbox{{ $role->id }}'>
                                                </td>
                                                <td class="py-1">{{ $counter++ }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <div class="dropdown action-dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="flaticon-dots"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                @can('roles.edit')
                                                                    <a href="{{ url('admin/roles/' . $role->id . '/edit') }}"
                                                                        class="dropdown-item" title="{{ __('Edit') }}">
                                                                        <i class="flaticon-editing"></i> {{__('Edit')}}
                                                                    </a>
                                                                @endcan
                                                            </li>
                                                            <li>
                                                                @can('roles.delete')
                                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#exampleModal{{ $role->id }}"
                                                                        title="{{ __('Delete') }}"><i
                                                                        
                                                                        class="flaticon-delete"></i> {{__('Delete')}}</a>
                                                                @endcan
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-------model Start ---->
                                            <div class="modal fade" id="exampleModal{{ $role->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                {{ __('Are You Sure ?') }}</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('Do you really want to delete') }} ?
                                                                {{ __('This process cannot be undone.') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="post"
                                                                action="{{ url('admin/roles/' . $role->id . '/delete') }}"
                                                                class="pull-right">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="reset" class="btn btn-secondary"
                                                                    title="{{ __('No') }}"
                                                                    data-bs-dismiss="modal">{{ __('No') }}</button>
                                                                <button type="submit" title="{{ __('Yes') }}"
                                                                    class="btn btn-primary">{{ __('Yes') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--- model end -->
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!-- Table end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bulk Delete Modal -->
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No') }}</button>
                    <form id="bulk_delete_form" method="post" action="{{ route('roles.bulk_delete') }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bulk Delete Modal end -->
@endsection
