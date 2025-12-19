@extends('admin.layouts.master')
@section('title', 'Newsletter')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb',['thirdactive' => 'active'])
        @slot('heading')
        {{ __('Newsletter ') }}
        @endslot
        @slot('menu1')
        {{ __('Front panel ') }}
        @endslot
        @slot('menu2')
        {{ __('Newsletter ') }}
        @endslot
        @slot('button')
        <div class="col-md-6 col-lg-6">
            @can('newsletter.delete')
                        <div class="widget-button">
                            <a type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#bulk_delete" title="{{ __('Delete')}}"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
                            <a href="{{ route('newsletter.trash') }}" type="button" class="btn btn-success" title="{{ __('Trash')}}"> <i class="flaticon-recycle"></i>
                                {{ __('Trash') }}</a>
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
                    <form action="{{ route('newsletter.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="client-detail-block">
                            <div class="form-group">
                                <label for="title" class="form-label">{{ __('Newsletter Title') }}<span class="required">*</span></label>
                                <input class="form-control form-control-lg @error('title') is-invalid @enderror"
                                       type="text" name="title" id="title"
                                       placeholder="{{ __('Please Enter Title') }}"
                                       value="{{ old('title') }}" required aria-label="Title">
                                <div class="form-control-icon"><i class="flaticon-customer"></i></div>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8">
                                        <label for="image" class="form-label">{{ __('Image') }}</label>
                                        <span class="required">*</span>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="suggestion-icon float-end">
                                            <div class="tooltip-icon">
                                                <div class="tooltip">
                                                    <div class="credit-block">
                                                        <small class="recommended-font-size">{{ __('Recommended Size : 720x900') }}</small>
                                                    </div>
                                                </div>
                                                <span class="float-end"><i class="flaticon-info"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input class="form-control form-control-lg @error('image') is-invalid @enderror"
                                       type="file" name="image" id="image" accept="image/*">
                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="btn_text" class="form-label">{{ __('Newsletter Button Text') }}<span class="required">*</span></label>
                                <input class="form-control form-control-lg @error('btn_text') is-invalid @enderror"
                                       type="text" name="btn_text" id="btn_text"
                                       placeholder="{{ __('Please Enter Button Text') }}"
                                       value="{{ old('btn_text') }}" required aria-label="Button Text">
                                <div class="form-control-icon"><i class="flaticon-customer"></i></div>
                                @error('btn_text')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="details" class="form-label">{{ __('Details') }}<span class="required">*</span></label>
                                <textarea class="form-control form-control-padding_15 @error('details') is-invalid @enderror"
                                          name="details" rows="4" placeholder="{{ __('Please Enter Your Details') }}"
                                          required>{{ old('details') }}</textarea>
                                @error('details')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group-btn">
                                <button type="submit" class="btn btn-warning me-1" name="status" value="draft">
                                    <i class="flaticon-draft"></i> {{ __('Save Draft') }}
                                </button>
                                <button type="submit" class="btn btn-success" name="status" value="publish">
                                    <i class="flaticon-paper-plane"></i> {{ __('Publish') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- form Code end -->
                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="client-detail-block">
                        <div class="table-responsive no-btn-table">
                            <!-- Table start-->
                            <table class="table data-table table-borderless"  id="example">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Button Text') }}</th>
                                        <th>{{ __('Details')}}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <!-- loop Print data show Start -->
                                <tbody id="sortable-table">
                                    @if (isset($newsletter))
                                        @foreach ($newsletter as $data)
                                            <tr data-id="{{ $data->id }}">
                                                <td><input type='checkbox' form='bulk_delete_form'
                                                        class='check filled-in material-checkbox-input form-check-input'
                                                        name='checked[]' value="{{ $data->id }}"
                                                        id='checkbox{{ $data->id }}'></td>
                                                <td>
                                                    @if (!empty($data->image))
                                                        <img src="{{ asset('/images/newsletter/' . $data->image) }}"
                                                            alt="{{ __('newsletter img') }}" class="widget-img">
                                                    @else
                                                        <img src="{{ Avatar::create($data->title)->toBase64() }}" />
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $data->title }}
                                                </td>
                                                <td>
                                                    {{$data->btn_text}}
                                                </td>
                                                <td>
                                                    {{$data->details}}
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
                                                        <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="flaticon-dots"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="#" class="dropdown-item" title="{{ __('View')}}">
                                                                    <i class="flaticon-view"></i> {{ __('View')}}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                @can('newsletter.edit')
                                                                    <a href="{{ url('admin/newsletter/' . $data->id . '/edit') }}" class="dropdown-item" title="{{ __('Edit')}}">
                                                                        <i class="flaticon-editing"></i> {{ __('Edit')}}
                                                                    </a>
                                                                @endcan
                                                            </li>
                                                            <li>
                                                                @can('newsletter.delete')
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal{{ $data->id }}" title="{{ __('Delete')}}"><i class="flaticon-delete"></i> {{ __('Delete')}}</a>
                                                                @endcan
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!--- model Start -->
                                            <div class="modal fade" id="exampleModal{{ $data->id }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                {{ __('Are You Sure ?') }}</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('Do you really want to delete') }} ?
                                                                {{ __('This process cannot be undone.') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="post"
                                                                action="{{ url('admin/newsletter/' . $data->id . '/delete') }}"
                                                                class="pull-right">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="reset" class="btn btn-secondary"
                                                                    data-dismiss="modal">{{ __('No') }}</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">{{ __('Yes') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--- model end --->
                                        @endforeach
                                        <!-- loop  Print data show end--->
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

                    <form id="bulk_delete_form" method="post" action="{{route('newsletter.bulk_delete')}}">
                        @csrf
                        @method('POST')
                        <button type="button" class="btn btn-secondary" title="{{ __('No') }}"
                            data-bs-dismiss="modal">{{ __('No') }}</button>
                        <button type="submit" class="btn btn-danger" title="{{ __('Yes') }}">{{ __('Yes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--------------------------------------- Bulk Delete Modal end---------------------------- -->
@endsection

