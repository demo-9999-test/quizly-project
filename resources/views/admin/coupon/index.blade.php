@extends('admin.layouts.master')
@section('title', 'Coupons')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Coupons') }}
    @endslot
    @slot('menu1')
    {{ __('Coupons') }}
    @endslot
    @slot('button')
    <div class="col-md-6 col-lg-6">
        @can('coupon.delete')
        <div class="widget-button">
            <a type="button" class="btn btn-danger " title="{{ __('Delete') }}" data-bs-toggle="modal"
                data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent
    <div class="contentbar  ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <!-- form Code start -->
                <form action="{{ route('coupon.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="form-group">
                            <label for="form-group" class="form-label">{{ __('Coupon Code') }}<span
                                    class="required">*</span></label>
                            <input class="form-control form-control-lg" type="text" name="coupon_code" id="coupon_code"
                                placeholder="{{ __('Please Enter Your Coupon Code') }}" aria-label="title" required
                                value="{{ old('coupon_code') }}">
                            <div class="form-control-icon"><i class="flaticon-promo-code"></i></div>
                        </div>
                        <div class="form-group">
                            <label for="client_name" class="form-label">{{ __('Discount Type') }}<span
                                    class="required">*</span></label>
                            <select class="form-select" aria-label=" " name="discount_type" id="discount_type">
                                <option value="fix" selected> {{ __('Fix Amount') }}</option>
                                <option value="percentage"> {{ __('% Percentage') }}</option>
                            </select>
                            <div class="form-control-icon"><i class="flaticon-discount"></i></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6" id="amountField">
                                <div class="form-group">
                                    <label for="fixed_amount" class="form-label">{{ __('Fixed Amount') }}<span class="required">*</span></label>
                                    <input class="form-control form-control-padding_15" type="number" name="fixed_amount"
                                        id="fixed_amount" placeholder="0.00" aria-label="fixed_amount"
                                        value="{{ old('fixed_amount') }}">
                                </div>
                            </div>
                            <div class="col-lg-6" id="percentageField">
                                <div class="form-group">
                                    <label for="percentage" class="form-label">{{ __('Percentage') }}<span class="required">*</span></label>
                                    <input class="form-control form-control-padding_15" type="number" name="percentage"
                                        id="percentage" placeholder="0.00" aria-label="percentage"
                                        value="{{ old('percentage') }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <label for="image" class="form-label">{{ __('Max Usage Limit') }}<span
                                                class="required">*</span></label>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="suggestion-icon float-end">
                                                <div class="tooltip-icon">
                                                    <div class="tooltip">
                                                        <div class="credit-block">
                                                            <small class="recommended-font-size">{{ __('( type 0 and this value in infinite limit )') }}</small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="form-control form-control-padding_15" type="number" name="limit" id=""
                                        placeholder="{{ __('Limit') }}" aria-label="title" required
                                        value="{{ old('limit') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="image" class="form-label">{{ __('Min Amount') }}<span
                                            class="required">*</span></label>
                                        <input class="form-control form-control-padding_15" type="number" name="min_amount"
                                            id="" placeholder="0.00" aria-label="title" required
                                            value="{{ old('min_amount') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="image" class="form-label">{{ __('Max Amount') }}</label>
                                        <input class="form-control form-control-padding_15" type="number" name="max_amount"
                                            id="" placeholder="0.00" aria-label="title" required
                                            value="{{ old('min_amount') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="image" class="form-label">{{ __('Start Date') }}<span
                                             class="required">*</span></label>
                                        <input class="form-control form-control-padding_15" type="date" name="start_date"
                                            id="" placeholder="{{ __('Please Enter Your Expiry Date') }}" aria-label="title"
                                            required value="{{ old('expirt_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="image" class="form-label">{{ __('Expiry Date') }}<span
                                            class="required">*</span></label>
                                        <input class="form-control form-control-padding_15" type="date" name="expiry_date"
                                            id="" placeholder="{{ __('Please Enter Your Expiry Date') }}" aria-label="title"
                                            required value="{{ old('expirt_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="status">
                                        <div class="form-group">
                                            <label for="status" class="form-label">{{ __('Code Display at Checkout')}}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                                name="code_display" value="1" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Only For New User ') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                                name="active_user" value="1" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" title="{{ __('Submit') }}"><i
                                class="flaticon-upload-1"></i>{{ __('Submit') }}</button>
                            </div>
                        </form>
                        <!-- form Code end -->
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="client-detail-block">
                            <div class="table-responsive no-btn-table">
                            <!-- table code start-->
                            <table class="table data-table table-borderless"  id="example" >
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                        <th>{{ __('Code') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Start Date') }}</th>
                                        <th>{{ __('Expiry Date') }}</th>
                                        <th>{{ __('Limit') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <!-- loop Print data show start -->
                                <tbody id="sortable-table">
                                    @if (isset($coupon))
                                    @foreach ($coupon as $data)
                                    <tr data-id="{{ $data->id }}">
                                        <td><input type='checkbox' form='bulk_delete_form'
                                                class='check filled-in material-checkbox-input form-check-input'
                                                name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'></td>
                                        <td>
                                            {{ $data->coupon_code }}
                                        </td>
                                        <td>
                                            {{ $data->discount_type }}
                                        </td>
                                        <td>
                                            {{ $data->start_date }}
                                        </td>
                                        <td>
                                            {{ $data->expiry_date }}
                                        </td>
                                        <td>
                                            {{ $data->limit }}
                                        </td>
                                        <td>
                                            <div class="dropdown action-dropdown">
                                                <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="flaticon-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        @can('coupon.edit')
                                                        <a href="{{ url('admin/coupon/' . $data->id . '/edit') }}"
                                                            class="dropdown-item" title="{{ __('Edit') }}">
                                                            <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                        </a>
                                                        @endcan
                                                    </li>
                                                    <li>
                                                        @can('coupon.delete')
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{ $data->id }}"
                                                            title="{{ __('Delete') }}"><i class="flaticon-delete"></i>{{ __('Delete') }}</a>
                                                        @endcan
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <!--  model Start -->
                                    <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-form-group fs-5" id="exampleModalLabel">{{ __('Are You Sure ?') }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{ __('Do you really want to delete') }} ?
                                                        {{ __('This process cannot be undone.') }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post"
                                                        action="{{ url('admin/coupon/' . $data->id . '/delete') }}"
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
                                    <!-- loop  Print data show end --->
                                    @endif
                                </tbody>
                            </table>
                            <!-- table code end  -->
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
                    <h1 class="modal-form-group fs-5" id="bulkDeleteLabel">{{ __('Delete Selected Records') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Do you really want to delete the selected records? This action cannot be undone.') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{__('No') }}</button>
                    <form id="bulk_delete_form" method="post" action="{{ route('coupon.bulk_delete') }}">
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

@section('scripts')
<script defer>
    document.addEventListener("DOMContentLoaded", function() {
        var discountTypeSelect = document.getElementById('discount_type');
        var amountField = document.getElementById('amountField');
        var percentageField = document.getElementById('percentageField');

        // Check if discountTypeSelect exists before adding event listener
        if (discountTypeSelect) {
            discountTypeSelect.addEventListener('change', function() {
                if (discountTypeSelect.value === 'fix') {
                    amountField.style.display = 'block';
                    percentageField.style.display = 'none';
                } else if (discountTypeSelect.value === 'percentage') {
                    amountField.style.display = 'none';
                    percentageField.style.display = 'block';
                } else {
                    amountField.style.display = 'none';
                    percentageField.style.display = 'none';
                }
            });
        }
    });
</script>
@endsection
