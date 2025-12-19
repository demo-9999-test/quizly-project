@extends('admin.layouts.master')
@section('title', 'Payment Request - Admin')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Payment Request') }}
    @endslot
    @slot('menu1')
    {{ __('Affiliate History') }}
    @endslot
    @slot('menu2')
    {{ __('Payment Request') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('payment.request.create') }}" class="btn btn-primary" title="{{ __("Request To Pay") }}">
                <i class="flaticon-arrow"></i>{{ __("Request To Pay") }}
            </a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block user-page">
                    <div class="table-responsive">
                        <!-- Table start-->
                         <table class="table display" id="">
                            <thead>
                                <tr>
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Bank Details') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    @if(Auth::user()->role == 'A')
                                    <th>{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <!-- loop Print data show Start -->
                            <tbody>
                                @php
                                    $totalAmount = 0;
                                @endphp
                                @if(!empty($pay_reqs) && $pay_reqs->count())
                                @foreach($pay_reqs as $key => $data)
                                @php
                                    $totalAmount += $data->amount;
                                @endphp
                                <tr>
                                    <td>{{ filter_var($key+1) }}</td>
                                    <td>{{ $data->bank_details }}</td>
                                    <td>{{ date('d/m/Y | h:i A',strtotime($data->created_at)) }}</td>
                                    <td>Rs. {{ $data->amount }}</td>
                                    <td>
                                        @if($data->status == 'Paid')
                                            {{ __('Paid') }}
                                        @else
                                            {{ $data->status }}
                                        @endif
                                    </td>
                                    @if(Auth::user()->role == 'A')
                                    <td>
                                        @if($data->status != 'Paid')
                                            <a href="{{ route('pay',$data->id) }}" class="btn btn-success px-2">
                                                {{ __("Pay") }}
                                            </a>
                                            @else
                                            {{ __('No Action') }}
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('There are no data.') }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <!-- Table end -->
                            </div>
                            <!-- Display Total Amount -->
                             <div class="text-center mt-4">
                                <strong>Total Amount: Rs. {{ $totalAmount }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
