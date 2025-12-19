@extends('admin.layouts.master')
@section('title', 'Post Trash')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Post') }}
    @endslot
    @slot('menu1')
    {{ __('Front Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Post') }}
    @endslot
    @slot('menu3')
    {{ __('Trash') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('post.show') }}" class="btn btn-primary"><i class="flaticon-back"></i>{{ __('Back') }}</a>
            <a type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#bulk_delete"><i
                class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block">
                    <div class="project-main-block">
                        <div class="table-responsive">

                            <!-- Table start -->
                            <table class="table data-table text-center" id="data-table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                        <th></th>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Approved') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                
                                <!-- loop  Print data show Start -->
                                <tbody>
                                    @if ($blog->isEmpty())
                                    <tr>
                                        <td colspan="7">{{ __('No data available') }}</td>
                                    </tr>
                                    @else
                                    @foreach ($blog as $data)
                                    <tr>
                                        <td><input type='checkbox' form='bulk_delete_form'
                                                class='check filled-in material-checkbox-input form-check-input'
                                                name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                        </td>
                                        <td class="py-1">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <img src="{{ asset('/images/blog/' . $data->images) }}"
                                                alt="{{ __('blog img') }}" class="img-fluid trash-img">
                                        </td>
                                        <td>
                                            {{ $data->title }}
                                        </td>
                                        <td>
                                            @if ($data->status == '0')
                                            <span class="badge bg-warning">{{ __('Draft') }}</span>
                                            @elseif ($data->status == '1')
                                            <span class="badge bg-success">{{ __('Publish') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->approved == 1)
                                            <span class="badge bg-success">{{ __('Approved') }}</span>
                                            @else
                                            <span class="badge bg-danger">{{ __('Pending') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown action-dropdown">
                                                <a class="dropdown-toggle" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="flaticon-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ url('admin/post/' . $data->id . '/restore') }}"
                                                            class="dropdown-item" title="{{ __('Restore')}}">
                                                            <i class="flaticon-restore"></i> {{ __('Restore') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{ $data->id }}"
                                                            title="{{ __('Delete')}}">
                                                            <i class="flaticon-delete"></i> {{ __('Delete') }}
                                                        </a>
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
                                                        action="{{ url('admin/post/' . $data->id . '/trash-delete') }}"
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
                            <!-- Table end -->
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
                <form id="bulk_delete_form" method="post" action="{{ route('post.trash_bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="submit" title="{{ __('Yes') }}" class="btn btn-danger">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bulk Delete Modal end -->
@endsection
