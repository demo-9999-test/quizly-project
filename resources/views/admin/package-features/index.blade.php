@extends('admin.layouts.master')
@section('title', 'Pacakage Features')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Packages Features') }}
    @endslot
    @slot('menu1')
    {{ __('Packages') }}
    @endslot
    @slot('menu2')
    {{ __('Packages Features') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        @can('packages_features.delete')
        <div class="widget-button">
            <a type="button" title="{{ __('Delete') }}" class="btn btn-danger " data-bs-toggle="modal"
                data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent

    <div class="contentbar bardashboard-card ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-4">
                <form action="{{ route('packages_features.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="form-group">
                            <label for="Title" class="form-label">{{ __('Package Feature') }}<span
                                    class="required">*</span></label>
                            <input class="form-control form-control-lg" type="text" name="title" id="title"
                                placeholder="{{ __('Please Enter Your Package Feature') }}" aria-label="title" required
                                value="{{ old('title') }}">
                            <div class="form-control-icon"><i class="flaticon-task"></i></div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" title="{{ __('Submit') }}"><i
                                class="flaticon-upload-1"></i> {{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-8">
                <div class="client-detail-block">
                    <div class="table-responsive no-btn-table">
                        <!-- table code start-->
                        <table class="table data-table table-borderless"  id="example">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                    <th>{{ __('Package Features Name') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <!----------- loop Print data show start ---------------- -->
                            <tbody id="sortable-table">
                                @if (isset($pfeatures))
                                @foreach ($pfeatures as $data)
                                <tr data-id="{{ $data->id }}">
                                    <td><input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input form-check-input'
                                            name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                    </td>
                                    <td>
                                        {{ $data->title }}
                                    </td>
                                    <td>
                                        <div class="dropdown action-dropdown">
                                            <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="flaticon-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    @can('packages_features.edit')
                                                    <a href="{{ url('admin/packages-features/' . $data->id . '/edit') }}"
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
                                                    action="{{ url('admin/packages-features/' . $data->id . '/delete') }}"
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
                                <!------------------- model end ----------------------->
                                @endforeach
                                <!---------- loop  Print data show end-------------------->
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="{{ __('No') }}">{{
                    __('No') }}</button>
                <form id="bulk_delete_form" method="post" action="{{ route('packages_features.bulk_delete') }}">
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
