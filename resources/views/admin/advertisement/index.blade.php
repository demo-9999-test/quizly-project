@extends('admin.layouts.master')
@section('title', 'Advertisements')
@section('main-container')
<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Advertisements') }}
    @endslot
    @slot('menu1')
    {{ __('Advertisements') }}
    @endslot
    @slot('button')
    <div class="col-md-6 col-lg-6">
        @can('advertisement.delete')
        <div class="widget-button">
            <a type="button" type="{{__('Delete')}}" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#bulk_delete"><i
                    class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
    @endcan
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <!-- form Code start -->
                <form action="{{ route('advertisement.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="form-group">
                            <label for="Title" class="form-label">{{ __('URL') }}<span class="required">*</span></label>
                            <input class="form-control" type="url" name="url" id="title"
                                placeholder="{{ __('Please Enter Your URL') }}" aria-label="title"
                                value="{{ old('coupon_code') }}">
                            <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                        </div>

                        <div class="form-group">
                            <label for="client_name" class="form-label">{{ __('Position') }}<span
                                    class="required">*</span></label>
                            <select class="form-select" aria-label=" " name="position">
                                <option selected disabled> {{ __('Please Select Position') }}</option>
                                <option value="bs"> {{ __('Below Slider') }}</option>
                                <option value="brc"> {{ __('Below Recent Courses') }}</option>
                                <option value="bbc"> {{ __('Below Bundle Courses') }}</option>
                                <option value="bt"> {{ __('Below Testimonial') }}</option>
                            </select>
                            <div class="form-control-icon"><i class="flaticon-position"></i></div>
                        </div>

                        <div class="form-group">
                            <label for="client_name" class="form-label">{{ __('Pages') }}<span
                                    class="required">*</span></label>
                            <select class="form-select"name="page_type">
                                <option selected disabled> {{ __('Please Select Page Type') }}</option>
                                <option value="hp"> {{ __('Home Page') }}</option>
                                <option value="ap"> {{ __('About Page') }}</option>
                                <option value="bp"> {{ __('Blog Page') }}</option>
                                <option value="tp"> {{ __('Testimonal Page') }}</option>
                                <option value="cp"> {{ __('Contact Page') }}</option>
                            </select>
                            <div class="form-control-icon"><i class="flaticon-task"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="Title" class="form-label">{{ __('Image') }}<span
                                    class="required">*</span></label>
                            <input class="form-control form-control-lg" type="file" name="image" id="title"
                                aria-label="image" required accept="image/*">
                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                        </div>
                        <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary mt-3"><i
                                class="flaticon-upload-1"></i>{{ __('Submit') }}</button>
                    </div>
                </form>
                <!-- form Code end -->
            </div>
            <div class="col-lg-9 col-md-6">
                <div class="client-detail-block">
                    <div class="table-responsive no-btn-table">
                        <!-- table code start --->
                        <table class="table data-table table-borderless" id="example">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('URL') }}</th>
                                    <th>{{ __('Position') }}</th>
                                    <th>{{ __('Page Type') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <!-- loop Print data show start  -->
                            <tbody id="sortable-table">
                                @if (isset($advertisement))
                                @foreach ($advertisement as $data)
                                <tr data-id="{{ $data->id }}">
                                    <td><input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input form-check-input'
                                            name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                    </td>
                                    <td>
                                        <img src="{{ asset('/images/advertisement/' . $data->image) }}"
                                            alt="{{ __('advertisement_image') }}" class="widget-img">
                                    </td>
                                    <td>
                                        <a href="{{$data->url}}" target="blank" class="url-tag" title="{{$data->url}}"> {{ $data->url }} </a>
                                    </td>

                                    <td>
                                        @if ($data->position === 'bs')
                                        {{ __('Below Slider') }}
                                        @endif

                                        @if ($data->position === 'brc')
                                        {{ __('Below Recent Courses') }}
                                        @endif

                                        @if ($data->position === 'bbc')
                                        {{ __('Below Bundle Courses') }}
                                        @endif

                                        @if ($data->position === 'bt')
                                        {{ __('Below Testimonial') }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($data->page_type === 'hp')
                                        {{ __('Home Page') }}
                                        @endif

                                        @if ($data->page_type === 'ap')
                                        {{ __('About Page') }}
                                        @endif

                                        @if ($data->page_type === 'bp')
                                        {{ __('Blog Page') }}
                                        @endif

                                        @if ($data->page_type === 'tp')
                                        {{ __('Testimonial Page') }}
                                        @endif
                                        @if ($data->page_type === 'cp')
                                        {{ __('Contact Page') }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown action-dropdown">
                                            <a class="dropdown-toggle" href="#" title="{{__('dot')}}" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="flaticon-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    @can('advertisement.edit')
                                                    <a href="{{ route('advertisement.edit', $data->id) }}" class="dropdown-item" title="{{ __('Edit') }}">
                                                        <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                    </a>
                                                    @endcan
                                                </li>
                                                <li>
                                                    @can('advertisement.delete')
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $data->id }}"
                                                        title="{{ __('Delete') }}"><i class="flaticon-delete"></i>
                                                        {{ __('Delete') }}</a>
                                                    @endcan
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!---model Start -->
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
                                                <form method="post" action="{{ route('advertisement.destroy', $data->id) }}"
                                                    class="pull-right">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="reset" title="{{ __('No') }}"
                                                        class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No')
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
                <form id="bulk_delete_form" method="post" action="{{ route('advertisement.bulk_delete') }}">
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