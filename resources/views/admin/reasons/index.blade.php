@extends('admin.layouts.master')
@section('title', 'Reasons')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Reasons') }}
    @endslot
    @slot('menu1')
    {{ __('Front Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Reasons') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        @can('reason.delete')
        <div class="widget-button">
            <a type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bulk_delete"><i class="flaticon-delete" title="{{__('Delete')}}"></i> {{ __('Delete') }}</a>
            <a href="{{ route('reason.trash') }}" type="button" class="btn btn-success" title="{{__('Trash')}}"><i class="flaticon-recycle"></i>{{ __('Trash') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <form action="{{route('reason.store')}}" method="post" enctype="multipart/form-data" id="postForm">
                    @csrf
                    <div class="client-detail-block mb-4">
                        <div class="form-group mb-4">
                            <label for="reason" class="form-label">{{ __('Reason') }}<span class="required">*</span></label>
                            <input class="form-control mb-2" type="text" name="reason" required id="reason" placeholder="{{ __('Enter Your Title') }}" aria-label="reason" value="{{ old('reason') }}">
                            <div class="form-control-icon"><i class="flaticon-title"></i></div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-4">
                            <div class="status">
                                <div class="form-group">
                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1" checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" title="{{ __('Add') }}"><i class="flaticon-paper-plane"></i> {{ __('Add') }}</button>
                </form>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="client-detail-block">
                    <div class="project-main-block">
                        <div class="table-responsive no-btn-table">

                            <!-- table code start -->
                            <table class="table data-table table-borderless"" id="example">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input" type="checkbox" id="checkboxAll"></th>
                                        <th>{{ __('Reason') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-table">
                                    @forelse ($reason as $data)
                                        <tr data-id="{{ $data->id }}">
                                            <td><input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input form-check-input' name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'></td>
                                            <td>
                                                {{ $data->reason }}
                                            </td>
                                            <td>
                                                <form action="{{ route('update.status', ['id' => $data->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input status22" type="checkbox" role="switch" id="statusToggle" name="approved" value="1" {{ $data->status == 1 ? 'checked' : '' }} onChange="this.form.submit()">
                                                    </div>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="dropdown action-dropdown">
                                                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="{{__('Dropdown')}}">
                                                        <i class="flaticon-dots"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            @can('reason.edit')
                                                                <a href="{{ url('admin/reasons/' . $data->id . '/edit') }}" class="dropdown-item" title="{{ __('Edit') }}">
                                                                    <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                                </a>
                                                            @endcan
                                                        </li>
                                                        <li>
                                                            @can('reason.delete')
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $data->id }}" title="{{ __('Delete') }}">
                                                                    <i class="flaticon-delete"></i> {{ __('Delete') }}
                                                                </a>
                                                            @endcan
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- modal Start -->
                                        <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Are You Sure ?') }}</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ __('Do you really want to delete') }}? {{ __('This process cannot be undone.') }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post" action="{{ url('admin/reasons/' . $data->id . '/delete') }}" class="pull-right">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button type="reset" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No') }}</button>
                                                            <button type="submit" title="{{ __('Yes') }}" class="btn btn-primary">{{ __('Yes') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- modal end -->

                                        @empty
                                        <tr>
                                            <td colspan="4">
                                            <p class="text-center">{{__('No data')}}</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Rest of your existing UI code -->
        </div>
    </div>
</div>

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
                <form id="bulk_delete_form" method="post" action="{{ route('reason.bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
