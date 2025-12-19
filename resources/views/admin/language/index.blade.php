@extends('admin.layouts.master')
@section('title', 'Language')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Languages') }}
    @endslot
    @slot('menu1')
    {{ __('Project Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Languages') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        @can('language.delete')
        <div class="widget-button">
            <a type="button" title="{{ __('Delete') }}" class="btn btn-danger " data-bs-toggle="modal"
                data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <!---form code start---->
                <form action="{{ route('language.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block mb-4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-10 col-10">
                                    <label for="Title" class="form-label">{{ __('Local') }}</label>
                                    <a href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes" target="blank"> <small
                                        class="link_recommendation"title="{{ __('(Language ISO Code)') }}">{{ __('(Language ISO Code)') }}</small></a>
                                    <span class="required">*</span>
                                </div>
                                <div class="col-lg-4 col-md-2 col-2">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small class="recommended-font-size">{{ __('(Ex. local: en)')}}</small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input class="form-control" type="text" name="local" id="title"
                                placeholder="{{ __('Enter Your Language Local Name') }}" aria-label="title" required
                                value="{{ old('local') }}">
                            <div class="form-control-icon"><i class="flaticon-language"></i></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-8">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <span class="required">*</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-4">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small class="recommended-font-size">{{ __('(Ex. Name: English)')
                                                        }}</small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input class="form-control" type="text" name="name"
                                placeholder="{{ __('Please Enter Your Language Name') }}" aria-label="Slug"
                                value="{{ old('name') }}" required>
                            <div class="form-control-icon"><i class="flaticon-user"></i></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-10 col-8">
                                    <label for="image" class="form-label">{{ __('Language Image') }}</label>
                                    <span class="required">*</span>
                                </div>
                                <div class="col-lg-4 col-md-2 col-4">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small class="recommended-font-size">{{ __('(Ex.') }}
                                                        <img src="{{ url('admin_theme/assets/images/country_flag/english.png') }}"
                                                            alt="{{ __('flag') }}" class="exmaple-img">{{ __(')') }}
                                                    </small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input class="form-control form-control-lg" type="file" name="image" id="image"
                                accept="image/*" required>
                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                        </div>
                        <div class="status">
                            <div class="form-group">
                                <label for="status" class="form-label">{{ __('Set Default') }}</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="status"
                                        value="1" checked>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" title="{{ __('Submit') }}"><i
                                class="flaticon-upload-1"></i> {{ __('Submit') }}</button>
                    </div>
                </form>
                <!---form code end---->
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="client-detail-block">
                    <div class="table-responsive no-btn-table">
                        <!-- table code start -->
                        <table  class="table data-table table-borderless"  id="example">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Local') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Default') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <!-- loop Print data show start -->
                            <tbody id="sortable-table">
                                @if (isset($language))
                                @foreach ($language as $data)
                                <tr data-id="{{ $data->id }}">
                                    <td><input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input form-check-input'
                                            name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                    </td>
                                    <td>
                                        @if (!empty($data->image))
                                        <img src="{{ asset('/images/language/' . $data->image) }}"
                                            alt=" {{ $data->name }}" class="exmaple-img">
                                        @else
                                        <img src="{{ Avatar::create($data->title)->toBase64() }}" alt=" {{ $data->name }}">
                                        @endif
                                    </td>
                                    <td>
                                        {{ $data->local }}
                                    </td>
                                    <td>
                                        {{ $data->name }}
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status55 toggle-switch" type="checkbox"
                                                role="switch" id="statusToggle{{ $data->id }}" name="status"
                                                data-id="{{ $data->id }}" value="{{ $data->status }}" {{ $data->status
                                            == 1 ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown action-dropdown">
                                            <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="flaticon-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    @can('language.edit')
                                                    <a href="{{ url('admin/language/' . $data->id . '/edit') }}"
                                                        class="dropdown-item" title="{{ __('Edit')}}">
                                                        <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                    </a>
                                                    @endcan
                                                </li>
                                                <li>
                                                    @can('language.delete')
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
                                <!--- model Start --->
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
                                                    action="{{ url('admin/language/' . $data->id . '/delete') }}"
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
                                <!-- loop  Print data show end --->
                                @endif
                            </tbody>
                        </table>
                        <!-- table code end  -->
                        <div class="d-flex justify-content-end">
                            <div class="pagination pagination-circle mb-3">
                                {{ $language->links() }}
                            </div>
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
                <form id="bulk_delete_form" method="post" action="{{ route('language.bulk_delete') }}">
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
