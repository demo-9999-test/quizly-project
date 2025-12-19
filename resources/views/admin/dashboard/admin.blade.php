@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('main-container')

    <div class="dashboard-card">
        <!-- Breadcrumb Start -->
        <nav class="breadcrumb-main-block" aria-label="breadcrumb">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumbbar">
                        <h4 class="page-title"> {{__('Hello, '. auth()->user()->name.'!')}} </h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb d-flex">
                                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" title="{{__('Dashboard')}}">{{ __('Dashboard') }}</a>
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
                    <div class="row mb-5">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="progress-block top-progress-block blue">
                                        <div class="row align-items-center">
                                            <div class="col-lg-5 col-md-4 col-4">
                                                <div class="progress-block-image ">
                                                    <img src="{{url('images/sidebar/user.png')}}"
                                                        class="img-fluid" alt="{{__('Total users')}}">
                                                </div>
                                                <div class="progress-block-image-dark">
                                                    <img src="{{url('images/sidebar/user-dark.png')}}"
                                                        class="img-fluid" alt="{{__('Total users')}}">
                                                </div>
                                                <div class="progress-dtls">
                                                    <h6 class="progress-heading">{{__('Total Users')}}</h6>
                                                    <h4 class="progress-count number">{{$user->count()}}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-8 col-8">
                                                <div class="user-growth-rate">
                                                    <h6 class="growth-rating">{{__('Growth Rate (Last 30 days)')}}</h6>
                                                    <p class="growth-percentage {{ $userGrowthInfo['rate'] > 0 ? 'text-success' : 'text-danger' }}">
                                                        <span class="number">{{ abs($userGrowthInfo['rate']) }}</span><span class="percent-sign">{{__('%')}}</span>
                                                    </p>
                                                    <p class="growth-date">{{ '(From: '.$userGrowthInfo['startDate'].')' }}</p>
                                                    <div class="row">
                                                        <div class="col-lg-6 mb-2">
                                                            <p class="growth-info">{{'Old Users: '. $userGrowthInfo['oldCount'] }}</p>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <p class="growth-info">{{'New Users: '. $userGrowthInfo['newCount'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="progress-block top-progress-block pink">
                                        <div class="row align-items-center">
                                            <div class="col-lg-4 col-md-4 col-4">
                                                <div class="progress-block-image">
                                                    <img src="{{url('images/sidebar/categories.png')}}"
                                                        class="img-fluid" alt="{{__('Categories')}}">
                                                </div>
                                                <div class="progress-block-image-dark">
                                                    <img src="{{url('images/sidebar/categories-dark.png')}}"
                                                        class="img-fluid" alt="{{__('Categories')}}">
                                                </div>
                                                <div class="progress-dtls">
                                                    <h6 class="progress-heading">{{__('Categories')}}</h6>
                                                    <h4 class="progress-count number">{{$category->count()}}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-8">
                                                <div class="user-growth-rate">
                                                    <h6 class="growth-rating">{{__('Growth Rate (Last 30 days)')}}</h6>
                                                    <p class="growth-percentage {{ $categoryGrowthInfo['rate'] > 0 ? 'text-success' : 'text-danger' }}">
                                                        <span class="number">{{ abs($categoryGrowthInfo['rate']) }}</span><span class="percent-sign">{{__('%')}}</span>
                                                    </p>
                                                    <p class="growth-date">{{ '(From: '.$categoryGrowthInfo['startDate'].')' }}</p>
                                                    <div class="row">
                                                        <div class="col-lg-6 mb-2">
                                                            <p class="growth-info">{{'Old Categories: '. $categoryGrowthInfo['oldCount'] }}</p>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <p class="growth-info">{{'New Categories: '. $categoryGrowthInfo['newCount'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="progress-block top-progress-block yellow">
                                        <div class="row align-items-center">
                                            <div class="col-lg-5 col-md-4 col-4">
                                                <div class="progress-block-image">
                                                    <img src="{{url('images/sidebar/battle.png')}}"
                                                        class="img-fluid" alt="{{__('battle modes')}}">
                                                </div>
                                                <div class="progress-block-image-dark">
                                                    <img src="{{url('images/sidebar/battle-dark.png')}}"
                                                        class="img-fluid" alt="{{__('battle modes')}}">
                                                </div>
                                                <div class="progress-dtls">
                                                    <h6 class="progress-heading">{{__('Battle modes')}}</h6>
                                                    <h4 class="progress-count number">{{$battle->count()}}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-8 col-8">
                                                <div class="user-growth-rate">
                                                    <h6 class="growth-rating">{{__('Growth Rate (Last 30 days)')}}</h6>
                                                    <p class="growth-percentage {{ $battleGrowthInfo['rate'] > 0 ? 'text-success' : 'text-danger' }}">
                                                        <span class="number">{{ abs($battleGrowthInfo['rate']) }}</span><span class="percent-sign">{{__('%')}}</span>
                                                    </p>
                                                    <p class="growth-date">{{ '(From: '.$battleGrowthInfo['startDate'].')' }}</p>
                                                    <div class="row">
                                                        <div class="col-lg-6 mb-2">
                                                            <p class="growth-info">{{'Old Users: '. $battleGrowthInfo['oldCount'] }}</p>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <p class="growth-info">{{'New Users: '. $battleGrowthInfo['newCount'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="progress-block red">
                                        <div class="row align-items-center">
                                            <div class="col-lg-9 col-md-9 col-9">
                                                <div class="progress-dtls">
                                                    <h6 class="progress-heading">{{ __('Total Quiz')}}</h6>
                                                    <h4 class="progress-count number">{{$quiz->count()}}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-3">
                                                <div class="progress-block-image">
                                                    <img src="{{url('images/sidebar/quiz.png')}}"
                                                        class="img-fluid" alt="{{__('Total Quiz')}}">
                                                </div>
                                                <div class="progress-block-image-dark">
                                                    <img src="{{url('images/sidebar/quiz-dark.png')}}"
                                                        class="img-fluid" alt="{{__('Total Quiz')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="progress-block purple">
                                        <div class="row align-items-center">
                                            <div class="col-lg-9 col-md-9 col-9">
                                                <div class="progress-dtls">
                                                    <h6 class="progress-heading">{{ __('Active Quiz')}}</h6>
                                                    <h4 class="progress-count number">{{$activequiz->count()}}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-3">
                                                <div class="progress-block-image">
                                                    <img src="{{url('images/sidebar/active-quiz.png')}}"
                                                        class="img-fluid" alt="{{__('Total Quiz')}}">
                                                </div>
                                                <div class="progress-block-image-dark">
                                                    <img src="{{url('images/sidebar/active-quiz-dark.png')}}"
                                                        class="img-fluid" alt="{{__('Total Quiz')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="progress-block dark_yellow">
                                        <div class="row align-items-center">
                                            <div class="col-lg-9 col-md-9 col-9">
                                                <div class="progress-dtls">
                                                    <h6 class="progress-heading">{{ __('Objective Quiz')}}</h6>
                                                    <h4 class="progress-count number">{{$objective->count()}}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-3">
                                                <div class="progress-block-image">
                                                    <img src="{{url('images/sidebar/objective.png')}}"
                                                        class="img-fluid" alt="{{__('Total Quiz')}}">
                                                </div>
                                                <div class="progress-block-image-dark">
                                                    <img src="{{url('images/sidebar/objective-dark.png')}}"
                                                        class="img-fluid" alt="{{__('Total Quiz')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="progress-block green_blue">
                                        <div class="row align-items-center">
                                            <div class="col-lg-9 col-md-9 col-9">
                                                <div class="progress-dtls">
                                                    <h6 class="progress-heading">{{ __('Subjective Quiz')}}</h6>
                                                    <h4 class="progress-count number">{{$subjective->count()}}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-3">
                                                <div class="progress-block-image">
                                                    <img src="{{url('images/sidebar/subjective.png')}}"
                                                        class="img-fluid" alt="{{__('Total Quiz')}}">
                                                </div>
                                                <div class="progress-block-image-dark">
                                                    <img src="{{url('images/sidebar/subjective-dark.png')}}"
                                                        class="img-fluid" alt="{{__('Total Quiz')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6">
                                            <div class="progress-block lgt_purple">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-9 col-md-9 col-9">
                                                        <div class="progress-dtls">
                                                            <h6 class="progress-heading">{{__('Total Orders')}}</h6>
                                                            <h4 class="progress-count number">{{$totalOrder->count()}}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <div class="progress-block-image">
                                                            <img src="{{url('images/sidebar/total-order.png')}}"
                                                                class="img-fluid" alt="{{__('Total Orders')}}">
                                                        </div>
                                                        <div class="progress-block-image-dark">
                                                            <img src="{{url('images/sidebar/total-order-dark.png')}}"
                                                                class="img-fluid" alt="{{__('Total Orders')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="progress-block cyan">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-9 col-md-9 col-9">
                                                        <div class="progress-dtls">
                                                            <h6 class="progress-heading">{{__('Successfull Orders')}}</h6>
                                                            <h4 class="progress-count number">{{$successOrder->count()}}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <div class="progress-block-image">
                                                            <img src="{{url('images/sidebar/success-order.png')}}"
                                                                class="img-fluid" alt="{{__('Successfull Orders')}}">
                                                        </div>
                                                        <div class="progress-block-image-dark">
                                                            <img src="{{url('images/sidebar/success-order-dark.png')}}"
                                                                class="img-fluid" alt="{{__('Successfull Orders')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="progress-block dark_red">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-9 col-md-9 col-9">
                                                        <div class="progress-dtls">
                                                            <h6 class="progress-heading">{{__('Failed Orders')}}</h6>
                                                            <h4 class="progress-count number">{{$failedOrder->count()}}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <div class="progress-block-image">
                                                            <img src="{{url('images/sidebar/failed-order.png')}}"
                                                                class="img-fluid" alt="{{__('Failed Orders')}}">
                                                        </div>
                                                        <div class="progress-block-image-dark">
                                                            <img src="{{url('images/sidebar/failed-order-dark.png')}}"
                                                                class="img-fluid" alt="{{__('Failed Orders')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                            <div class="progress-block v_lgt_yellow">
                                                <div class="row align-items-center">
                                                    <div class="col-lg-9 col-md-9 col-9">
                                                        <div class="progress-dtls">
                                                            <h6 class="progress-heading">{{__('Pending Orders')}}</h6>
                                                            <h4 class="progress-count number">{{$pendingOrder->count()}}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-3">
                                                        <div class="progress-block-image">
                                                            <img src="{{url('images/sidebar/pending-order.png')}}"
                                                                class="img-fluid" alt="{{__('Active users')}}">
                                                        </div>
                                                        <div class="progress-block-image-dark">
                                                            <img src="{{url('images/sidebar/pending-order-dark.png')}}"
                                                                class="img-fluid" alt="{{__('Pending Orders')}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="client-detail-block statics-block">
                                <div class="chart-block">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-6">
                                            <h5 class="dashboard-title">{{__("New Users")}}</h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-6">
                                            <div class="interval-dropdown text-end">
                                                <select id="userIntervalSelect" class="form-select">
                                                    <option value="monthly">{{__('Monthly')}}</option>
                                                    <option value="weekly">{{__('Weekly')}}</option>
                                                    <option value="yearly">{{__("Yearly")}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="newUsersChart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="recent-table-block client-detail-block">
                                <h5 class="dashboard-title">{{__('Recent Orders')}}</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tbody>
                                            @forelse ($recentOrders as $data)
                                                <tr class="order-list">
                                                    <td width="20%">
                                                        @if (!empty($data->user->image))
                                                        <img src="{{ asset('images/users/' . $data->user->image) }}" class="img-fluid" alt="{{ $data->user->name }}">
                                                        @else
                                                            <img src="{{ Avatar::create($data->user->name)->toBase64() }}"  alt=" {{ ($data->user->name) }}">
                                                        @endif
                                                    </td>
                                                    <td width="45%">
                                                        <h5 class="order-name">{{ $data->user->name }}</h5>
                                                        <p class="order-name">{{ $data->package->pname }}</p>
                                                    </td>
                                                    <td width="35%" class="text-end">
                                                        <h6 class="order-price">{{ $data->total_amount }} {{ $data->currency_icon }}</h6>
                                                        <p class="order-time">{{ $data->created_at->diffForHumans() }}</p>
                                                    </td>
                                                </tr>
                                            @empty
                                            <p>{{ __('No transactions yet') }}</p>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="client-detail-block">
                                <h5 class="dashboard-title">{{('Top Rankers')}}</h5>
                                @php
                                    $allZero = $rankers->take(4)->every(function ($data) {
                                        return $data->score == 0 && $data->rank == 0;
                                    });
                                @endphp
                                @if($allZero)
                                    <p class="no-rank">{{__('Rank not declared yet')}}</p>
                                @else
                                <div class="top-user-slider">
                                    @foreach ($rankers->take(4) as $data)
                                        @if($data->role != 'A')
                                            <div class="top-users-block">
                                                <div class="row">
                                                    <div class="col-lg-12 text-center">
                                                        @if(!is_null($data->image) && $data->image !== '')
                                                            <div class="top-user-img" style="background-color: {{ $data->bannerColor }}">
                                                                <a href="{{route('friend.page',['slug'=>$data->slug])}}" title="{{ $data->name }}"><img src="{{asset('images/users/'.$data->image)}}" class="img-fluid" alt="{{ $data->name }}"></a>
                                                            </div>
                                                        @else
                                                            <div class="top-user-img" style="background-color: {{ $data->bannerColor }}">
                                                                <a href="{{route('friend.page',['slug'=>$data->slug])}}" title="{{ $data->name }}"><img src="{{ Avatar::create($data->name)->toBase64() }}" class="img-fluid friend-img " alt="{{ $data->name }}"></a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="top-user-dtls mt-3">
                                                            <a href="{{route('friend.page',['slug'=>$data->slug])}}" title="{{ $data->name }}"><h5 class="top-user-name">{{ $data->name }}</h5></a>
                                                            <a href="{{route('friend.page',['slug'=>$data->slug])}}" title="{{ $data->name }}"><h6 class="top-user-username">{{ '@'. $data->slug }}</h6></a>
                                                            <div class="row">
                                                                <div class="col-lg-6 col-6 text-center">
                                                                    <h6>{{('Rank')}}</h6>
                                                                    {{$data->rank}}
                                                                </div>
                                                                <div class="col-lg-6 mb-4 col-6 text-center">
                                                                    <h6>{{('Score')}}</h6>
                                                                    {{$data->score}}
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <p class="top-user-contact email">{{'Email: '.$data->email}}</p>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <p class="top-user-contact phone">{{'Phone: '.$data->mobile}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="client-detail-block slider-client">
                                <h5 class="dashboard-title">{{('Latest Quizzes')}}</h5>
                                <div class="latest-quiz-slider">
                                    @forelse ($latest_quiz as $data )
                                        <div class="latest-quiz-block">
                                            @if(!is_null($data->image) && $data->image !== '')
                                                <a href="" title="{{ $data->name }}"><img src="{{asset('images/quiz/'.$data->image)}}" class="img-fluid" alt="{{ $data->name }}"></a>
                                            @else
                                                <a href="" title="{{ $data->name }}"><img src="{{ Avatar::create($data->name)->toBase64() }}" class="img-fluid" alt="{{ $data->name }}"></a>
                                            @endif
                                            <div class="latest-quiz-dtls">
                                                <h5 class="latest-quiz-name">{{$data->name}}</h5>
                                                @if($data->type==1)
                                                    <p class="latest-quiz-type obj">{{__('Objective')}}</p>
                                                @else
                                                    <p class="latest-quiz-type sub">{{__('Subjective')}}</p>
                                                @endif
                                                <div class="row text-center">
                                                    <div class="col-lg-6">
                                                        <h6 class="from-to-heading">{{__('From')}}</h6>
                                                        <p>{{$data->start_date}}</p>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h6 class="from-to-heading">{{__('To')}}</h6>
                                                        <p>{{$data->end_date}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                            <p>{{ __('No quiz is uploaded yet') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="client-detail-block statics-block">
                                <div class="chart-block">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-6">
                                            <h5 class="dashboard-title">{{__("New Orders")}}</h5>
                                        </div>
                                        <div class="col-lg-8 col-md-6 col-6">
                                            <div class="interval-dropdown text-end">
                                                <select id="orderIntervalSelect" class="form-select">
                                                    <option value="monthly">{{__('Monthly')}}</option>
                                                    <option value="weekly">{{__('Weekly')}}</option>
                                                    <option value="yearly">{{__("Yearly")}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="newOrdersChart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="client-detail-block statics-block">
                                <div class="chart-block">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-6">
                                            <h5 class="dashboard-title">{{__("Quiz Performance")}}</h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-6">
                                            <div class="interval-dropdown text-end">
                                                <select id="quizIntervalSelect" class="form-select">
                                                    <option value="monthly">{{__('Monthly')}}</option>
                                                    <option value="weekly">{{__('Weekly')}}</option>
                                                    <option value="yearly">{{__("Yearly")}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div id="quizChart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contentbar -->
@endsection

