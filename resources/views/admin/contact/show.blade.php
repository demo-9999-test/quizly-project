@extends('admin.layouts.master')
@section('title', 'Contact')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Contact') }}
    @endslot
    @slot('menu1')
    {{ __('Help & Support') }}
    @endslot
    @slot('menu2')
    {{ __('Contact') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        @can('contact.delete')
        <div class="widget-button">
            <a type="button" class="btn btn-danger" title="{{ __('Delete') }}" data-bs-toggle="modal"
                data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a> 
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent

    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <!-- form Code start -->
                <form action="{{ route('contact.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block mb-4">
                        <div class="form-group">
                            <label for="title" class="form-label">{{ __('Name') }}<span
                                    class="required">*</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                placeholder="{{__('Please Enter Your Name')}}" value="{{ old('name') }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="form-control-icon"><i class="flaticon-user"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="form-label">{{ __('Email') }}<span
                                    class="required">*</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email"
                                id="email" placeholder="{{ __('Enter Your email') }}" aria-label="email"
                                value="{{ old('email') }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="form-control-icon"><i class="flaticon-email"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="form-label">{{ __('Subject') }}<span
                                    class="required">*</span></label>
                            <input class="form-control" type="text" name="subject" id="subject"
                                placeholder="{{ __('Enter Your Subject') }}" value="{{ old('subject') }}">
                            <div class="form-control-icon"><i class="flaticon-email"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="form-label">{{ __('Number') }}<span
                                    class="required">*</span></label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="number"
                                name="mobile" id="number" placeholder="{{ __('Enter Your Number') }}"
                                aria-label="number" value="{{ old('mobile') }}">
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="form-control-icon"><i class="flaticon-telephone"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="form-label">{{ __('Message') }}<span
                                    class="required">*</span></label>
                            <textarea class="form-control form-control-padding_15 @error('msg') is-invalid @enderror"
                                name="msg" id="desc" cols="30" rows="5"
                                placeholder="{{__('Please enter your message')}}">{{ old('msg') }}</textarea>
                            @error('msg')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group-btn">
                            <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary"><i
                                    class="flaticon-upload-1"></i> {{ __('Submit') }}</button>
                        </div>
                    </div>
                </form>
                <!-- form Code end -->
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="client-detail-block">
                    <div class="table-responsive no-btn-table">
                        <!-- table code start -->
                        <table class="table data-table table-borderless"  id="example">
                            <thead>
                                <tr>
                                    <th><input class="form-check-input" type="checkbox" id="checkboxAll"></th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Number') }}</th>
                                    <th>{{ __('Message') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <!-- loop Print data show start -->
                            <tbody id="sortable-table">
                                @if (isset($contacts))
                                <?php $i = 0; ?>
                                @foreach ($contacts as $data)
                                <?php $i++; ?>
                                <tr data-id="{{ $data->id }}">
                                    <td><input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input form-check-input'
                                            name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                    </td>
                                    <td>
                                        {{ $data->name }}
                                    </td>
                                    <td>
                                        {{ $data->email }}
                                    </td>
                                    <td>
                                        {{ $data->mobile }}
                                    </td>
                                    <td>
                                        {{ Illuminate\Support\Str::limit($data->msg, $limit = 50, $end = '...') }}
                                    </td>
                                    <td>
                                    <div class="dropdown action-dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="flaticon-dots"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a data-bs-toggle="modal" data-bs-target="#viewModal{{ $data->id }}"                                                        class="dropdown-item" title="{{ __('View') }}"><i
                                                            class="flaticon-view"></i>{{ __('View') }}</a>
                                            </li>
                                                @can('contact.delete')
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $data->id }}"
                                                    title="{{ __('Delete')}}"><i class="flaticon-delete"></i> {{__('Delete')}}</a>
                                            </li>
                                                @endcan
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
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Are You Sure ?') }}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ __('Do you really want to delete') }} ?
                                                    {{ __('This process cannot be undone.') }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post"
                                                    action="{{ url('admin/contact/' . $data->id . '/delete') }}"
                                                    class="pull-right">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="reset" class="btn btn-secondary"
                                                        title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No')}}</button>
                                                    <button type="submit" {{ __('Yes') }} class="btn btn-primary">{{__('Yes') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade contact-view-modal" id="viewModal{{ $data->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleSmallModalLabel">
                                                    {{ __('Contact Details') }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label for="Title" class="form-label">{{ __('Name')
                                                                }}</label>
                                                            <input type="text" class="form-control form-control-lg"
                                                                id="Name" value="{{ $data->name }}" readonly>
                                                            <div class="form-control-icon"><i class="flaticon-user"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label for="Title" class="form-label">{{ __('Email')
                                                                }}</label>
                                                            <input type="text" class="form-control form-control-lg"
                                                                id="Name" value="{{ $data->email }}" readonly>
                                                            <div class="form-control-icon"><i
                                                                    class="flaticon-email"></i></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4">
                                                        <div class="form-group mb-3">
                                                            <label for="Title" class="form-label">{{ __('Mobile Number')
                                                                }}</label>
                                                            <input type="text" class="form-control form-control-lg"
                                                                id="Name" value="{{ $data->mobile }}" readonly>
                                                            <div class="form-control-icon"><i
                                                                    class="flaticon-telephone"></i></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-3">
                                                            <label for="Title" class="form-label">{{ __('Message')
                                                                }}</label>
                                                            <textarea class="form-control form-control-padding_15"
                                                                name="msg" id="desc" cols="30" rows="2"
                                                                readonly>{{ $data->msg }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
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
                        <div class="d-flex justify-content-end">
                            <div class="pagination pagination-circle mb-3">
                                {{ $contacts->links() }}
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
                <form id="bulk_delete_form" method="post" action="{{ route('contact.bulk_delete') }}">
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
