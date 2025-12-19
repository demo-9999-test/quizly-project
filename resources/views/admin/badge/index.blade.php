@extends('admin.layouts.master')
@section('title', 'Badge')
@section('main-container')

<div class="dashboard-card">

    @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
        @slot('heading')
            {{ __('Badge') }}
        @endslot
        @slot('menu1')
            {{ __('Badge') }}
        @endslot
        @slot('button')

            <div class="col-md-6 col-lg-6">
                <div class="widget-button">
                    @can('badge.create')
                    <a href="{{ route('badge.create') }}" type="button" class="btn btn-primary p-2" title={{__('Add Badge')}}>
                        <i class="flaticon-plus"></i>  {{ __('Add Badge') }}</a>
                        @endcan
                        @can('badge.delete')
                        <a type="button" class="btn btn-danger" title="{{ __('Delete') }}" data-bs-toggle="modal"
                        data-bs-target="#bulk_delete" title="{{__('Delete')}}"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
                        <a href="{{ route('badge.trash') }}" type="button" class="btn btn-success"
                        title=" {{ __('Trash') }}"><i class="flaticon-recycle"></i>
                        {{ __('Trash') }}</a>
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
                                    <!--Table Start-->
                                    <table class="table data-table table-borderless" id="example">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                                <th>{{ __('#') }}</th>
                                                <th>{{__('Badge Image')}}</th>
                                                <th>{{ __('Badge Name') }}</th>
                                                <th>{{ __('Badge Description') }}</th>
                                                <th>{{ __('Milestone')}}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <!-- loop  Print data show Start --->
                                         <tbody>
                                            @php
                                            $counter = 1;
                                            @endphp
                                            @foreach ($badges as $data)
                                            <tr>
                                                <td><input type="checkbox" form="bulk_delete_form"
                                                class="check filled-in material-checkbox-input form-check-input"
                                                name="checked[]" value="{{ $data->id }}" id="checkbox{{ $data->id }}"></td>
                                                <td>{{ $counter++ }}</td>
                                                <td>
                                                    @if (!empty($data->image))
                                                    <img src="{{ asset('/images/badge/' . $data->image) }}" alt=" {{ __('Badge img') }}" class="widget-img img-fluid">
                                                    @else
                                                    <img src="{{ Avatar::create($data->name)->toBase64() }}"  alt=" {{ __('Badge img') }}">
                                                    @endif
                                                </td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->description }}</td>
                                                <td>{{$data->score}}</td>
                                                <td>@if ($data->status == 1)
                                                    <span class="badge bg-success">{{__('Active')}}</span>
                                                    @else
                                                    <span class="badge bg-danger">{{__('Not Active')}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown action-dropdown">
                                                        <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="flaticon-dots"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            @can('badge.edit')
                                                            <a href="{{ route('badge.edit', ['id' => $data->id]) }}"
                                                            class="dropdown-item" title="{{ __('Edit')}}">
                                                            <i class="flaticon-editing"></i> {{ __('Edit')}}
                                                        </a>
                                                        @endcan
                                                    </li>
                                                    <li>
                                                        @can('badge.delete')
                                                        <a class="dropdown-item" href="#" title="{{ __('Delete')}}" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $data->id }}">
                                                            <i class="flaticon-delete"></i> {{ __('Delete')}}
                                                        </a>
                                                        @endcan
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                {{-- -------------model Start ------------------- --}}
                                    <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">{{ __('Confirm Delete') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('Are you sure you want to delete this quiz?') }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <form id="deleteForm" action="{{ route('badge.destroy', ['id' => $data->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-primary">{{ __('Delete') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ------------- model end ------------------------- --}}
                                    @endforeach
                                </tbody>
                            </table>
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
                    <form id="bulk_delete_form" method="post" action="{{ route('badge.bulk_delete') }}">
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
