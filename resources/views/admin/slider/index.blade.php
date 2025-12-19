@extends('admin.layouts.master')
@section('title', 'Sliders')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Sliders ') }}
    @endslot
    @slot('menu1')
    {{ __('Front Settings ') }}
    @endslot
    @slot('menu2')
    {{ __('Sliders ') }}
    @endslot
    @slot('button')
    <div class="col-md-6 col-lg-6">
        @can('slider.delete')
        <div class="widget-button">
            <a type="button" class="btn btn-danger " title="{{ __('Delete') }}" data-bs-toggle="modal"
                data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
            <a href="{{ route('slider.trash') }}" title=" {{ __('Trash') }}" type="button" class="btn btn-success"> <i
                    class="flaticon-recycle"></i>
                {{ __('Trash') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent



    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <!---form code start-->
                <form action="{{ route('slider.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="form-group">
                            <label for="heading" class="form-label">{{ __('Heading') }}<span
                                    class="required">*</span></label>
                            <input class="form-control" type="text" name="heading" required id="heading"
                                placeholder="{{ __('Please Enter Your Heading Name') }}" aria-label="Heading">
                            <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="sub_heading" class="form-label">{{ __('Sub Heading') }}<span class="required">*</span></label>
                            <input class="form-control" type="text" name="sub_heading" id="sub_heading"
                                placeholder="{{ __('Please Enter Your Sub Heading') }} " aria-label="sub_heading">
                            <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="text_position" class="form-label">{{ __('Text Position') }}<span class="required">*</span></label>
                            <select class="form-select" aria-label=" " name="text_position" required>
                                <option selected disabled>{{ __('Select Text Position') }}</option>
                                <option value="l">{{ __('Left') }}</option>
                                <option value="c">{{ __('Center') }}</option>
                                <option value="r">{{ __('Right') }}</option>
                            </select>
                            <div class="form-control-icon"><i class="flaticon-position"></i></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-8">
                                    <label for="image" class="form-label">{{ __('Image') }}<span class="required">*</span></label>
                                    
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small class="recommended-font-size">{{ __('Recommended Size :
                                                        720x900') }}</small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input class="form-control" type="file" name="images" id="image" accept="image/*"
                                alt="widget-img">
                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="form-label">{{ __('Details') }}<span
                                    class="required">*</span></label>
                            <textarea class="form-control form-control-padding_15" name="details" id="desc" required rows="4"
                                placeholder="{{ __('Please Enter Your Details') }}"></textarea>
                        </div>
                        <div class="form-group" id="form-group-status">
                            <label for="btn_status" class="form-label">{{ __('Button Status') }}</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input service-quiz @error('status') is-invalid @enderror" type="checkbox" role="switch" id="btn_status" name="btn_status" value="1" {{ old('btn_status') ? 'checked' : '' }} checked>
                            </div>
                        </div>
                        <div class="form-group" id="form-group-buttontext">
                            <label for="buttontext" class="form-label">{{ __('Button text') }}<span class="required">*</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="buttontext" id="buttontext" placeholder="{{ __('Enter text of button') }}" aria-label="Button Text" value="{{ old('buttontext') }}">
                            <div class="form-control-icon"><i class="flaticon-speech-bubble-1"></i></div>
                        </div>
                        <div class="form-group-btn">
                            <button type="submit" class="btn btn-warning me-1" name="status"
                                title="{{ __('Save Draft') }}" value="draft"><i class="flaticon-draft"></i> {{ __('Save
                                Draft') }}</button>
                            <button type="submit" class="btn btn-success" name="status" value="publish"
                                title="{{ __('Publish') }}"><i class="flaticon-paper-plane"></i> {{ __('Publish')
                                }}</button>
                        </div>
                    </div>
                </form>
                <!-- form code end--->
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="client-detail-block">
                    <div class="table-responsive no-btn-table">
                        <!--table code start-->
                        <table  class="table data-table table-borderless"  id="example">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                    <th>{{ __('Images') }}</th>
                                    <th>{{ __('Heading') }}</th>
                                    <th>{{ __('Sub Heading') }}</th>
                                    <th>{{ __('Text Position') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <!-- loop  Print data show Start-->
                            <tbody id="sortable-table">
                                @if (isset($slider))
                                @foreach ($slider as $data)
                                <tr data-id="{{ $data->id }}">
                                    <td><input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input form-check-input'
                                            name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'></td>
                                    <td>
                                        @if (!empty($data->images))
                                        <img src="{{ asset('/images/slider/' . $data->images) }}"
                                            alt=" {{ __('slider img') }}" class="widget-img">
                                        @else
                                        <img src="{{ Avatar::create($data->title)->toBase64() }}" alt=" {{ __('slider img') }}" class="widget-img">
                                        @endif
                                    </td>

                                    <td>
                                        {{ $data->heading }}
                                    </td>
                                    <td>
                                        {{ $data->sub_heading ?: '-----' }}
                                    </td>
                                    <td>
                                        @if ($data->text_position === 'l')
                                        {{ __('Left') }}
                                        @endif

                                        @if ($data->text_position === 'c')
                                        {{ __('Center') }}
                                        @endif

                                        @if ($data->text_position === 'r')
                                        {{ __('Right') }}
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
                                            <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="flaticon-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    @can('slider.edit')
                                                    <a href="{{ url('admin/slider/' . $data->id . '/edit') }}"
                                                        class="dropdown-item" title="{{ __('Edit') }}">
                                                        <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                    </a>
                                                    @endcan
                                                </li>
                                                <li>
                                                    @can('slider.delete')
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $data->id }}"
                                                        title="{{ __('Delete') }}"><i class="flaticon-delete"></i> {{
                                                        __('Delete') }}</a>
                                                    @endcan
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!--model Start  -->
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
                                                    action="{{ url('admin/slider/' . $data->id . '/delete') }}"
                                                    class="pull-right">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="reset" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">{{ __('No') }}</button>
                                                    <button type="submit" class="btn btn-primary">{{ __('Yes')
                                                        }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--model end  -->
                                @endforeach
                                <!--- loop  Print data show end-->
                                @endif
                            </tbody>
                            <!-- loop  Print data show end-->
                        </table>
                        <!--table code end-->
                        <div class="d-flex justify-content-end">
                            <div class="pagination pagination-circle mb-3">
                                {{ $slider->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- Bulk Delete Modal start --->
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

                <form id="bulk_delete_form" method="post" action="{{ route('slider.bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{
                        __('No') }}</button>
                    <button type="submit" class="btn btn-primary" title="{{ __('Yes') }}">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--- Bulk Delete Modal end -->

@endsection
@section('scripts')
<script>
    var baseUrl = "{{ url('/') }}";
</script>
<script src="{{ url('admin_theme/assets/js/slider.js') }}"></script>
@endsection
