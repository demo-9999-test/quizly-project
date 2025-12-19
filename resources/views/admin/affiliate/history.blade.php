@extends('admin.layouts.master')
@section('title', 'Affiliate History - Admin')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Affiliate') }}
    @endslot
    @slot('menu1')
    {{ __('Affiliate History') }}
    @endslot
    @slot('menu2')
    {{ __('Affiliate') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a class="btn btn-primary" type="button" href="{{ route('payment.request') }}"
                title="{{ __('Request To Pay') }}">
                {{ __('Request To Pay') }}
            </a>
        </div>
    </div>
    @endslot
    @endcomponent
    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block user-page">
                    <div class="table-responsive">
                        <!-- Table start-->
                        <table class="table data-table table-borderless"  id="example" >
                            <thead>
                                <tr>
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Refered User') }}</th>
                                    <th>{{ __('Refered By') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                </tr>
                            </thead>
                            <!-- loop Print data show Start -->
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($history as $key => $data)
                                <tr>
                                    <td>{{ filter_var($key + 1) }}</td>
                                    <td>
                                        @isset($data->refer_user)
                                            {{ $data->refer_user->name }} ({{ $data->refer_user->email }})
                                        @else
                                            No refer user
                                        @endisset
                                    </td>
                                    <td>{{ $data->user ? $data->user->name : '' }}
                                        ({{ $data->user ? $data->user->email : '' }})</td>
                                    <td>{{ date('d/m/Y | h:i A', strtotime($data->created_at)) }}</td>
                                    <td>{{ $data->amount }}</td>
                                </tr>
                                @php $total += $data->amount; @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Table end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
