@extends('admin.layouts.master')
@section('title', 'Pages')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Pages ') }}
    @endslot
    @slot('menu1')
    {{ __('Front Panel') }}
    @endslot
    @slot('menu2')
    {{ __('Pages ') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        @can('pages.delete')
        <div class="widget-button">
            <a type="button" class="btn btn-danger" title="{{ __('Delete') }}" data-bs-toggle="modal"
                data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
            <a href="{{ route('pages.trash') }}" type="button" class="btn btn-success" title="{{ __('Trash') }}"> <i
                    class="flaticon-recycle"></i>{{ __('Trash') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent

    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
                <div class="row">
            <div class="col-lg-4 col-md-5">
                <!--form code start -->
                <form action="{{ route('pages.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block mb-4">
                        <div class="form-group">
                            <label for="heading" class="form-label">{{ __('Page Title') }}<span
                                    class="required">*</span></label>
                            <input class="form-control" type="text" name="title" id="heading"
                                placeholder="{{ __('Please Enter Page Title')}}" required aria-label="title"
                                value="{{ old('title') }}">
                            <div class="form-control-icon"><i class="flaticon-title"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="form-label">{{ __('Slug') }}<span class="required">*</span></label>
                            <input class="form-control" type="text" name="slug" id="slug"
                                placeholder="{{ __('Please Enter Your Slug')}}" required aria-label="Slug"
                                value="{{ old('slug') }}">
                            <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="client_name" class="form-label">{{ __('Page Type') }}<span
                                    class="required">*</span></label>
                            <select class="form-select" aria-label=" " name="page_link">
                                <option selected disabled> {{ __('Select Page Type') }}</option>
                                <option value="tc"> {{ __('Terms And Conditions') }}
                                </option>
                                <option value="pp"> {{ __('Privacy Policy') }}</option>
                                <option value="retp">{{ __('Return Policy') }} </option>
                                <option value="refp">{{ __('Refund Policy') }} </option>
                                <option value="ap">{{ __('Affiliate Policy') }} </option>
                                <option value="gp">{{ __('General Policy') }} </option>
                                <option value="au">{{ __('About Us') }} </option>
                                <option value="sp">{{ __('Shipping Policy') }} </option>
                                <option value="tp">{{ __('Terms And Use Policy') }}
                                </option>
                                <option value="cp">{{ __('Cookiee Policy') }} </option>
                                <option value="op">{{ __('Other Pages') }} </option>
                            </select>
                            <div class="form-control-icon"><i class="flaticon-pages"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="form-label">{{ __('Details') }}<span
                                    class="required">*</span></label>
                            <textarea class="form-control" name="desc" id="desc" required rows="4"
                                placeholder="{{ __('Please Enter Your Details')}}"></textarea>
                        </div>
                        <div class="form-group-btn">
                            <button type="submit" class="btn btn-warning me-1" name="status" value="draft"><i
                                    class="flaticon-draft"></i> {{ __('Save Draft') }}</button>
                            <button type="submit" class="btn btn-success" name="status" value="publish"><i
                                    class="flaticon-paper-plane"></i> {{ __('Publish') }}</button>
                        </div>
                    </div>
                </form>
                <!-- form code end -->
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="client-detail-block">
                    <div class="project-main-block">
                        <div class="table-responsive no-btn-table">
                            <table  class="table data-table table-borderless"  id="example">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Slug') }}</th>
                                        <th>{{ __('Page Type ') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <!-- loop  Print data show Start -->
                                <tbody id="sortable-table">
                                    @if (isset($pages))
                                    @foreach ($pages as $data)
                                    <tr data-id="{{ $data->id }}">
                                        <td><input type='checkbox' form='bulk_delete_form'
                                                class='check filled-in material-checkbox-input form-check-input'
                                                name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                        </td>
                                        <td>
                                            <a href="#" target="blank" class="url-tag" title="{{ $data->title }}"> {{ $data->title }}</a>
                                        </td>
                                        <td>
                                            {{ $data->slug }}
                                        </td>
                                        <td>
                                            @if ($data->page_link === 'tc')
                                            {{ __('Terms And Conditions') }}
                                            @endif

                                            @if ($data->page_link === 'pp')
                                            {{ __('Privacy Policy') }}
                                            @endif

                                            @if ($data->page_link === 'retp')
                                            {{ __('Return Policy') }}
                                            @endif

                                            @if ($data->page_link === 'refp')
                                            {{ __('Refund Policy') }}
                                            @endif

                                            @if ($data->page_link === 'ap')
                                            {{ __('Affiliate Policy') }}
                                            @endif

                                            @if ($data->page_link === 'gp')
                                            {{ __('General Policy') }}
                                            @endif

                                            @if ($data->page_link === 'au')
                                            {{ __('About Us') }}
                                            @endif

                                            @if ($data->page_link === 'sp')
                                            {{ __('Shipping Policy') }}
                                            @endif

                                            @if ($data->page_link === 'tp')
                                            {{ __('Terms And Use Policy') }}
                                            @endif

                                            @if ($data->page_link === 'cp')
                                            {{ __('Cookie Policy') }}
                                            @endif

                                            @if ($data->page_link === 'op')
                                            {{ __('Other Pages') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->status == '0')
                                            <span class="badge bg-warning">{{ __('Draft') }}</span>
                                            @elseif ($data->status == '1')
                                            <span class="badge bg-success">{{ __('Published') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown action-dropdown">
                                                <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="flaticon-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" class="dropdown-item" title="{{ __('View')}}">
                                                            <i class="flaticon-view"></i> {{ __('View')}}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        @can('pages.edit')
                                                        <a href="{{ url('admin/pages/' . $data->id . '/edit') }}"
                                                            class="dropdown-item" title="{{ __('Edit')}}">
                                                            <i class="flaticon-editing"></i> {{ __('Edit')}}
                                                        </a>
                                                        @endcan
                                                    </li>
                                                    <li>
                                                        @can('pages.create')
                                                        <a href="{{ url('admin/pages/' . $data->id . '/copy') }}"
                                                            class="dropdown-item" title="{{ __('Copy')}}">
                                                            <i class="flaticon-copy"></i> {{ __('Copy')}}
                                                        </a>
                                                        @endcan
                                                    </li>
                                                    <li>
                                                        @can('pages.delete')
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
                                                        action="{{ url('admin/pages/' . $data->id . '/delete') }}"
                                                        class="pull-right">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="reset" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ __('No') }}</button>
                                                        <button type="submit" class="btn btn-primary">{{ __('Yes')}}</button>
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
                            <div class="d-flex justify-content-end">
                                <div class="pagination pagination-circle mb-3">
                                    {{ $pages->links() }}
                                </div>
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

                <form id="bulk_delete_form" method="post" action="{{ route('pages.bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bulk Delete Modal end -->
@endsection

@section('scripts')
<script>
    var baseUrl = "{{ url('/') }}";
</script>
<script src="{{ url('admin_theme/assets/js/pages.js') }}"></script>
@endsection
