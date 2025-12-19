@extends('front.layouts.master')
@section('title', 'Coins')
@section('content')

<!--Start Breadcrumb-->
<div id="breadcrumb" class="breadcrumb-main-block"
    @if(isset($setting->breadcrumb_img) && $setting->breadcrumb_img)
        style="background-image: url('{{ asset('images/breadcrumb/'.$setting->breadcrumb_img) }}')"
    @endif
>
    <div class="overlay-bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center ">
                <nav  style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <h2 class="breadcrumb-title mb_30">{{__('Coins')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Coins')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->
<!-- Coins Start -->
<section id="coins" class="coins-main-block">
    <div class="container">
        <div class="row mb_30">
            <div class="col-lg-10 col-md-8">
                <h2 class="coins-title mb_20">{{('Coin details for: ' .  $user->name)}}</h2>
            </div>
            <div class="col-lg-2 col-md-4 text-center">
                <div class="coins-box">
                    <h5 class="coins-sub-title">{{__('Current Balance')}}</h5>
                    <h3 class="coins-txt">{{ $user->coins }}<span class="coins-icon"><i class="flaticon-coin-1"></i></span></h3>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">{{ __('Overview')}}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false">{{ __('History')}}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="earnings-tab" data-bs-toggle="tab" data-bs-target="#earnings" type="button" role="tab" aria-controls="earnings" aria-selected="false">{{ __('Earnings')}}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="spending-tab" data-bs-toggle="tab" data-bs-target="#spending" type="button" role="tab" aria-controls="spending" aria-selected="false">{{ __('Spending')}}</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                <div class="row">
                    <!-- Coin Balance Graph -->
                    <div class="col-lg-9 col-md-8 mb-4">
                        <div class="coins-details-block mb_30">
                            <h3 class="coins-details-title mb_30">{{__('Coin Balance Over Time')}}</h3>
                            <div id="coinBalanceChart"></div>
                        </div>
                        <div class="coins-details-block">
                            <h3 class="coins-details-title mb_30">{{__('Recent Transactions')}}</h3>
                            <div class="table-responsive">
                                <table class="table  transaction-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Status')}}</th>
                                            <th>{{ __('Amount')}}</th>
                                            <th>{{ __('Method')}}</th>
                                            <th>{{ __('Time')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $coins = DB::table('coins')
                                                ->where('user_id', Auth::user()->id)
                                                ->orderBy('created_at', 'desc')
                                                ->take(3)
                                                ->get();
                                        @endphp
                                        @forelse ($coins as $data )
                                        <tr>
                                            <td>
                                                @if($data->status == 'credited')
                                                    <h5 class="credited">{{$data->status}}</h5>
                                                @else
                                                    <h5 class="debited">{{$data->status}}</h5>
                                                @endif
                                            </td>
                                            <td>
                                                <h5 class="amount">{{$data->ammount}}</h5>
                                            </td>
                                            <td>
                                                <p class="method">{{$data->method}}</p>
                                            </td>
                                            <td>{{Carbon\Carbon::parse($data->created_at)->diffForHumans()}}</td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3"> {{__('No transaction yet')}} </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="coins-details-block stats-block mb_30">
                            <h4 class="coins-details-title mb_20">{{__('Quick Stats')}}</h4>
                            <ul class="coins-details-lst">
                                <li>{{'Total Earned: ' .$total_earned}}<i class="flaticon-coin-1"></i></li>
                                <li>{{'Total Spent: ' .$total_spent}}<i class="flaticon-coin-1"></i></li>
                                <li><hr></li>
                                <li>{{'Highest Balance: ' .$highest_balance}}<i class="flaticon-coin-1"></i></li>
                            </ul>
                        </div>
                        <div class="coins-details-block stats-block">
                            <h4 class="coins-details-title mb_20">{{__('Earn more coins')}}</h4>
                            <ul class="coins-details-lst">
                                <li><a href="{{url('/profile#plans')}}" title="{{ __('plans')}}" class="more-way">{{ __('Buy coins')}}</a></li>
                                <li><a href="{{url('/profile#refer')}}" title="{{ __('refer and earn')}}" class="more-way">{{ __('Refer and earn')}}</a></li>
                                <li><a href="{{route('discover.page')}}" title="{{ __('play quiz')}}" class="more-way">{{ __('Play quiz')}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                <div class="row">
                    <!-- Filtering and Date Range -->
                    <div class="col-md-12 mb_30">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-12 mb_30">
                                <select class="form-select" id="transactionTypeFilter" aria-label="Filter transactions">
                                    <option value="all" {{ request('transaction_type') == 'all' ? 'selected' : '' }}>{{ __('All Transactions')}}</option>
                                    <option value="earnings" {{ request('transaction_type') == 'earnings' ? 'selected' : '' }}>{{ __('Earnings Only')}}</option>
                                    <option value="spendings" {{ request('transaction_type') == 'spendings' ? 'selected' : '' }}>{{ __('Spendings Only')}}</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-8 col-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">{{__('Date Range')}}</span>
                                    <input type="text" class="form-control" id="dateRangePicker">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="coins-details-block mb_30">
                    <div class="row">
                        <h4 class="coins-details-title mb_20">{{__('Transaction history')}}</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table history-table">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('Details')}}
                                    </th>
                                    <th>
                                        {{ __('Status')}}
                                    </th>
                                    <th>
                                        {{ __('Amount')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $data )
                                <tr>
                                    <td>
                                        <div class="history-method">
                                            <h5 class="history-heading">{{$data->method}}</h5>
                                            <small class="history-date">{{$data->created_at->diffForHumans()}}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($data->status == 'credited')
                                        <span class="credited">{{$data->status}}</span>
                                        @else
                                            <span class="debited">{{$data->status}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="history-cost">
                                            <h5 class="history-amount">{{$data->ammount}}</h5>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3">{{__('No transaction yet')}} </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @php
                        use Carbon\Carbon;
                        $startDateFormatted = Carbon::parse($startDate)->format('d-m-Y');
                        $endDateFormatted = Carbon::parse($endDate)->format('d-m-Y');
                    @endphp
                    <h5 class="coins-date-data">{{'Showing data from: '.$startDateFormatted.' to '.$endDateFormatted }}</h5>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $history->appends(request()->query())->links() }}
                </div>
            </div>
            <div class="tab-pane fade" id="earnings" role="tabpanel" aria-labelledby="earnings-tab">
                <div class="row">
                    <div class="col-md-4">
                        <div class="coins-details-block mb_30">
                            <div class="row align-items-center">
                                <div class="col-lg-9">
                                    <h3 class="coins-details-title mb_10">{{__('Total Earnings')}}</h3>
                                    <h4 class="coins-details-title">{{$total_earned . ' Coins'}}</h4>
                                </div>
                                <div class="col-lg-3">
                                    <div class="coin-details-icon">
                                        <i class="flaticon-coin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="coins-details-block mb_30">
                            <h3 class="coins-details-title mb_30">{{__('Recent Earnings')}}</h3>
                            <div class="table-responsive">
                                <table class="table history-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                {{ __('Details')}}
                                            </th>
                                            <th>
                                                {{ __('Status')}}
                                            </th>
                                            <th>
                                                {{ __('Amount')}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($credited_history as $data )
                                        <tr>
                                            <td>
                                                <div class="history-method">
                                                    <h5 class="history-heading">{{$data->method}}</h5>
                                                    <small class="history-date">{{$data->created_at->diffForHumans()}}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="credited">{{$data->status}}</span>
                                            </td>
                                            <td>
                                                <div class="history-cost">
                                                    <h5 class="history-amount">{{$data->ammount}}</h5>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <td colspan="3">{{__('No transaction yet')}} </td>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="pagination">
                            {{ $credited_history->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="spending" role="tabpanel" aria-labelledby="spending-tab">
                <div class="row">
                    <div class="col-md-4">
                        <div class="coins-details-block mb_30">
                            <div class="row align-items-center">
                                <div class="col-lg-9">
                                    <h3 class="coins-details-title mb_20">{{__('Total Spending')}}</h3>
                                    <h4 class="coins-details-title">{{$total_spent . ' Coins'}}</h4>
                                </div>
                                <div class="col-lg-3">
                                    <div class="coin-details-icon">
                                        <i class="flaticon-coin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="coins-details-block mb_30">
                            <h3 class="coins-details-title mb_30">{{__('Recent Earnings')}}</h3>
                            <div class="table-responsive">
                                <table class="table table-responsive history-table">
                                    <thead>
                                        <tr>
                                            <th>
                                                {{ __('Details')}}
                                            </th>
                                            <th>
                                                {{ __('Status')}}
                                            </th>
                                            <th>
                                                {{ __('Amount')}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($debited_history as $data )
                                        <tr>
                                            <td>
                                                <div class="history-method">
                                                    <h5 class="history-heading">{{$data->method}}</h5>
                                                    <small class="history-date">{{$data->created_at->diffForHumans()}}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="debited">{{$data->status}}</span>
                                            </td>
                                            <td>
                                                <div class="history-cost">
                                                    <h5 class="history-amount">{{$data->ammount}}</h5>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3">{{__('No transaction yet')}} </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="pagination">
                            {{ $debited_history->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Coins end -->
@endsection
