@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('main-container')

    <div class="dashboard-card">
        <!-- Breadcrumb Start -->
        <nav class="breadcrumb-main-block" aria-label="breadcrumb">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumbbar">
                        <h4 class="page-title"> {{ 'Marketing Dashboard!' }} </h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb d-flex">
                                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" title="{{ __('Dashboard') }}">{{ __('Dashboard') }}</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Breadcrumb End -->

        <!-- Start Contentbar -->
        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="sidebar-main-block">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="client-detail-block statics-block">
                            <div class="chart-block">
                                <div class="row align-items-center">
                                    <div class="col-lg-10 col-md-9 col-9">
                                        <h5>{{('Revenue Chart for:')}} <span id="selectedYearDisplay">{{ $selectedYear }}</span></h5>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-3">
                                        <select id="yearSelector" class="form-select marketing-dropdown">
                                            @foreach($availableYears as $year)
                                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ 'Year: '.$year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="revenueChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="client-detail-block statics-block">
                            <div class="chart-block">
                                <div class="row align-items-center">
                                    <div class="col-lg-10 col-md-9 col-9">
                                        <h5>{{__('Package Sales for')}} <span id="packageSalesYearDisplay">{{ $selectedYear }}</span></h5>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-3">
                                        <select id="packageSalesYearSelector" class="form-select marketing-dropdown">
                                            @foreach($availableYears as $year)
                                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ 'Year: '.$year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="packageSalesChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="client-detail-block ">
                            @forelse($topPackages as $package)
                            <div class="summary-card red">
                            @php
                                $currency = DB::table('currencies')->where('default', 1)->first();
                                $convertedRevenue = currencyConverter($package->package->currency, $currency->code, $package->total_revenue);
                                // Always run, no error on zero
                                $percentageOfTotal = ($totalRevenue != 0)
                                    ? round(($package->total_revenue / $totalRevenue) * 100, 2)
                                    : 0;
                            @endphp
                            
                                <h5 class="summary-card-title">{{ $package->package->pname }}</h5> <!-- Package Name -->
                                <h4 class="total-revenue">{{ $currency->symbol }} {{ $convertedRevenue }}</h4> <!-- Total Revenue -->
                                <p class="revenue-percentage">
                                    {{ $percentageOfTotal }}{{__('%')}} {{ __('of Total Revenue') }}
                                </p> <!-- Percentage of Total Revenue -->
                                <i class="revenue-icon fas fa-dollar-sign"></i> <!-- Icon -->
                            </div>
                            @empty
                                <p>{{__('No packages found.')}}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
