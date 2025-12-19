@extends('admin.layouts.master')
@section('title', 'Packages ')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Packages ') }}
    @endslot
    @slot('menu1')
    {{ __('Packages') }}
    @endslot
    @slot('menu2')
    {{ __('Packages ') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        @can('packages.delete')
        <div class="widget-button">
            <a type="button" class="btn btn-danger " title="{{ __('Delete') }}" data-bs-toggle="modal"
                data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent

    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
                <div class="row">
            <div class="col-lg-4 col-md-4">
                <form action="{{ route('packages.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="form-group">
                            <label for="plan_id" class="form-label">{{ __('Plan Unique ID') }}<span
                                    class="required">*</span></label>
                            <input class="form-control" type="text" name="plan_id" id=""
                                placeholder="{{ __('Please Enter Your Plan Unique ID') }}" aria-label="" required
                                value="{{ old('plan_id') }}">
                            <div class="form-control-icon"><i class="flaticon-id-card"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="pname" class="form-label">{{ __('Package Name') }}<span
                                    class="required">*</span></label>
                            <input class="form-control" type="text" name="pname" id="pname"
                                placeholder="{{ __('Please Enter Your Package Name') }}" aria-label="" required
                                value="{{ old('pname') }}">
                            <div class="form-control-icon"><i class="flaticon-user"></i></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-8">
                                    <label for="package-feature" class="form-label">{{ __('Package Feature') }}<span
                                            class="required">*</span></label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-4">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <a type="button" title="{{__('Add freatures')}}" class="btn " data-bs-toggle="modal"
                                                data-bs-target="#addfeatures"> <i class="flaticon-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <select class="form-select select2-multi-select" name="pfeatures_id[]" multiple="multiple">
                                @foreach ($pfeatures as $data)
                                <option value="{{ $data->id }}"> {{ $data->title }}</option>
                                @endforeach
                            </select>
                            <div class="form-control-icon"><i class="flaticon-features"></i></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="form-label">{{ __('Plan Price') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control form-control-lg" type="number" name="plan_amount"
                                        id="" placeholder="0.00" aria-label="" value="{{ old('plan_amount') }}"
                                        min="0">
                                    <div class="form-control-icon"><i class="flaticon-gross"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="preward" class="form-label">{{ __('Package reward') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control" type="number" name="preward" id="preward"
                                        placeholder="{{ __('Coin') }}" aria-label="" required
                                        value="{{ old('preward') }}">
                                    <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">{{ __('Status') }}</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="" name="status"
                                    value="1" checked>
                            </div>
                        </div>
                        <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary mt-3"><i
                                class="flaticon-upload-1"></i>{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="client-detail-block">
                    <div class="table-responsive no-btn-table">
                        <!-- table code start -->
                        <table class="table data-table table-borderless"  id="example" >
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                    <th>{{ __('Package Name') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Coins Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <!-- loop Print data show start  -->
                            <tbody id="sortable-table">
                                @if (isset($package))
                                @foreach ($package as $data)
                                <tr data-id="{{ $data->id }}">
                                    <td><input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input form-check-input'
                                            name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'></td>
                                    <td>
                                        {{ $data->pname }}
                                    </td>
                                    <td>
                                        {{$currency->symbol}} {{ currencyConverter($data->currency, $currency->code,
                                        $data->plan_amount)}}
                                    </td>
                                    <td>
                                        {{ $data->preward }}
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status2" type="checkbox" role="switch"
                                                id="statusToggle" name="status" data-id="{{ $data->id }}"
                                                value="{{ $data->status }}" {{ $data->status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown action-dropdown">
                                            <a class="dropdown-toggle" href="#" title="{{__('Dropdown')}}" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="flaticon-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    @can('packages.edit')
                                                    <a href="{{ url('admin/packages/' . $data->id . '/edit') }}"
                                                        class="dropdown-item" title="{{ __('Edit') }}">
                                                        <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                    </a>
                                                    @endcan
                                                </li>
                                                <li>
                                                    @can('packages.delete')
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
                                <!-- model Start-->
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
                                                    action="{{ url('admin/packages/' . $data->id . '/delete') }}"
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
                                <!-- model end --->
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

<!--- Bulk Delete Modal start -->
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
                <form id="bulk_delete_form" method="post" action="{{ route('packages.bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--- Bulk Delete Modal end -->

<!-- add  features  Modal start -->
<div class="modal fade" id="addfeatures" tabindex="-1" aria-labelledby="bulkDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bulkDeleteLabel">{{ __('Package Feature Add') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('packages_features.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Title" class="form-label">{{ __('Package Feature') }}<span
                                class="required">*</span></label>
                        <input class="form-control form-control-lg" type="text" name="title" id="title"
                            placeholder="{{ __('Please Enter Your Package Feature') }}" aria-label="title" required
                            value="{{ old('title') }}">
                        <div class="form-control-icon"><i class="flaticon-task"></i></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{
                        __('No') }}</button>
                    <form id="bulk_delete_form" method="post" action="{{ route('post.bulk_delete') }}">
                        @csrf
                        @method('POST')
                        <button type="submit" title="{{ __('Yes') }}" class="btn btn-primary">{{ __('Yes') }}</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- add  features  Modal end -->

@endsection

