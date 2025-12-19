@extends('admin.layouts.master')
@section('title', 'Manual Payment Gateway')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['secondaryactive' => 'active'])
        @slot('heading')
        {{ __('Manual Payment Gateway') }}
        @endslot
        @slot('menu1')
        {{ __('Manual Payment Gateway') }}
        @endslot
        @slot('button')
        
        <div class="col-md-6 col-lg-6">
            <div class="widget-button">
                @can('manual-payment.create')
                <a href="{{ route('manual.create') }}" type="button" class="btn btn-primary"
                    title="{{ __('Add') }}"><i class="flaticon-plus"></i> {{ __('Add') }}</a>
                @endcan

                @can('manual-payment.delete')
                <a type="button" class="btn btn-danger" title="{{ __('Delete') }}" data-bs-toggle="modal"
                    data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
                @endcan
            </div>
        </div>
        @endslot
        @endcomponent
    <!-- Breadcrumb Start -->

    <!-- Breadcrumb End -->
    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block user-page">
                    <div class="table-responsive">
                        <!-- Table start-->
                        <table class="table data-table display" id="example">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                    <th>{{ __('Payment Gateway Name') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <!-- loop  Print data show Start --->
                            <tbody>
                                @foreach ($payment as $data)
                                <tr>
                                    <td>
                                        <input type="checkbox" form="bulk_delete_form"
                                            class="check filled-in material-checkbox-input form-check-input"
                                            name="checked[]" value="{{ $data->id }}" id="checkbox{{ $data->id }}">
                                    </td>
                                    <td>
                                        {{ $data->gateway_name }}

                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status88" type="checkbox" role="switch"
                                                id="statusToggle" name="status" data-id="{{ $data->id }}"
                                                value="{{ $data->status }}" {{ $data->status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown action-dropdown">
                                            <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="flaticon-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                @can('manual-payment.edit')
                                                <li>
                                                    <a href="{{ url('admin/manual_payment/' . $data->id . '/edit') }}"
                                                        class="dropdown-item" title="{{ __('Edit')}}">
                                                        <i class="flaticon-editing"></i> {{ __('Edit')}}
                                                    </a>
                                                </li>
                                                @endcan
                                               @can('manual-payment.delete')
                                               <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $data->id }}"
                                                    title="{{ __('Delete')}}"><i class="flaticon-delete"></i> {{
                                                    __('Delete')}}</a>
                                            </li>
                                               @endcan

                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                {{-- -------------model Start ------------------- --}}
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
                                                    action="{{ url('admin/manual-payment/' . $data->id . '/delete') }}"
                                                    class="pull-right">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">{{ __('No') }}</button>
                                                    <button type="submit" class="btn btn-primary">{{ __('Yes')
                                                        }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- ------------- model end ------------------------- --}}
                                @endforeach
                                <!---- loop  Print data show end----------------------------->
                            </tbody>
                        </table>
                        <!-- Table end -->
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No') }}</button>
                <form id="bulk_delete_form" method="post" action="{{ route('manual.bulk_delete') }}">
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
