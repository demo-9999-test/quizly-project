@extends('admin.layouts.master')
@section('title', 'Post Categories')
@section('main-container')
<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Post Categories') }}
    @endslot
    @slot('menu1')
    {{ __('Front Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Post Categories') }}
    @endslot
    @slot('button')
    <div class="col-md-6 col-lg-6">
        @can('blog.delete')
        <div class="widget-button">
            <a type="button" class="btn btn-danger " title="{{__('Delete')}}" data-bs-toggle="modal" data-bs-target="#bulk_delete"><i
                    class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
                <div class="row">
            <div class="col-lg-4 col-md-5">
                <!-- form Code start -->
                <form action="{{ route('post_category.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block mb-4">
                        <div class="form-group">
                            <label for="title" class="form-label">{{ __('Categories') }}<span
                                    class="required">*</span></label>
                            <input class="form-control" type="text" name="categories" required id="categories"
                                placeholder="{{ __('Enter Your categories') }}" aria-label="title"
                                value="{{ old('categories') }}">
                            <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-4">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                                name="status" value="1" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="flaticon-upload-1"></i>
                                {{ __('Submit') }}</button>
                        </div>
                    </div>

                </form>
                <!-- form Code end -->
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="client-detail-block">
                    <div class="project-main-block">
                        <div class="table-responsive no-btn-table">
                            <!-- table code start -->
                            <table  class="table data-table table-borderless"  id="example">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input" type="checkbox" id="checkboxAll"></th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <!-- loop Print data show start -->
                                <tbody>
                                    @if (isset($category))
                                    @foreach ($category as $data)
                                    <tr data-id="{{ $data->id }}">
                                        <td><input type='checkbox' form='bulk_delete_form'
                                                class='check filled-in material-checkbox-input form-check-input'
                                                name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                        </td>
                                        <td>
                                            {{ $data->categories }}
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status7" type="checkbox" role="switch"
                                                    id="statusToggle" name="status" data-id="{{ $data->id }}"
                                                    value="{{ $data->status }}" {{ $data->status == 1 ? 'checked' :
                                                ''
                                                }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown action-dropdown">
                                                <a class="dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false" title="{{__('Dropdown')}}">
                                                    <i class="flaticon-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        @can('blog.edit')
                                                        <a href="{{ url('admin/post-category/' . $data->id . '/edit') }}"
                                                            class="dropdown-item" title="{{ __('Edit')}}">
                                                            <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                        </a>
                                                        @endcan
                                                    </li>
                                                    <li>
                                                        @can('blog.delete')
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
                                    <!-- model Start -->
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
                                                        action="{{ url('admin/post-category/' . $data->id . '/delete') }}"
                                                        class="pull-right">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="reset" class="btn btn-secondary"
                                                            title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No')
                                                            }}</button>
                                                        <button type="submit" title="{{ __('Yes') }}"
                                                            class="btn btn-primary">{{ __('Yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- model end -->
                                    @endforeach
                                    <!-- loop  Print data show end -->
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
                <form id="bulk_delete_form" method="post" action="{{ route('post-category.bulk_delete') }}">
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
