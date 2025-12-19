@extends('front.layouts.master')
@section('title', 'Quizly | Leadboard')
@section('content')

<!--Start Breadcrumb-->
<div id="breadcrumb" class="breadcrumb-main-block"
    @if(isset($setting->breadcrumb_img) && $setting->breadcrumb_img)
        style="background-image: url('{{ asset('images/breadcrumb/'.$setting->breadcrumb_img) }}')"
    @endif

    <div class="overlay-bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center ">
                <nav  style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <h2 class="breadcrumb-title mb_30">{{__('Leaderboard')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Leaderboard')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--end Breadcrumb-->

<section id="leaderboard-tabs" class="leaderboard-tab-main-block">
    <div class="container">
        @if($allEmpty)
        <div class="nothing-here-block">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="{{asset('images/nothing-here/nothing-01.jpg')}}" class="img-fluid mb_30" alt="{{__('Nothing here')}}">
                    <h2>{{__('Seems like no-one played quiz yet')}}</h2>
                    <p>{{__('Check back soon when result is published!')}}</p>
                </div>
            </div>
        </div>
        @else
            <div id="leaderboard-tab" class="leaderboard-tab">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="item nav-item" role="presentation">
                        <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">{{ __('All time')}}</button>
                    </li>
                    <li class="item nav-item" role="presentation">
                        <button class="nav-link" id="pills-monthly-tab" data-bs-toggle="pill" data-bs-target="#pills-monthly" type="button" role="tab" aria-controls="pills-monthly" aria-selected="false">{{ __('Monthly')}}</button>
                    </li>
                    <li class="item nav-item" role="presentation">
                        <button class="nav-link" id="pills-today-tab" data-bs-toggle="pill" data-bs-target="#pills-today" type="button" role="tab" aria-controls="pills-today" aria-selected="false">{{ __('Todays')}}</button>
                    </li>
                </ul>
            </div>
            <div class="half-circle"></div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab" tabindex="0">
                    <div class="leaderboard-toppers">
                        @if($allTime_rank2 != NULL && $allTime_rank1 != NULL && $allTime_rank3 != NULL && $allTime_rest != NULL)
                        <div class="row">
                            <div class="col-lg-4 text-center">
                                <div class="topper runner-up">
                                    @if ($allTime_rank2->user->image !== NULL && $allTime_rank2->user->image !== '')
                                        <div class="topper-img">
                                            <a href="{{route('friend.page',['slug'=>$allTime_rank2->user->slug])}}" title="{{$allTime_rank2->user->name}}"><img src="{{ asset('images/users/' . $allTime_rank2->user->image) }}" class="img-fluid top-player-img" alt="{{ $allTime_rank2->user->name }}"></a>
                                            <span class="badge runner-up-badge">{{__('2')}}</span>
                                        </div>
                                    @else
                                        <div class="topper-img">
                                            <a href="{{route('friend.page',['slug'=>$allTime_rank2->user->slug])}}" title="{{ $allTime_rank2->user->name }}"><img src="{{ Avatar::create($allTime_rank2->user->name)->toBase64() }}" class="img-fluid top-player-img" alt="{{ $allTime_rank2->user->name }}"></a>
                                            <span class="badge runner-up-badge">{{__('2')}}</span>
                                        </div>
                                    @endif
                                    <div class="topper-dtls">
                                        <a href="{{route('friend.page',['slug'=>$allTime_rank2->user->slug])}}" title="{{$allTime_rank2->user->name}}"><h4 class="topper-name"> {{$allTime_rank2->user->name}} </h4></a>
                                        <a href="{{route('friend.page',['slug'=>$allTime_rank2->user->slug])}}" title="{{$allTime_rank2->user->name}}"><h6 class="topper-score">{{$allTime_rank2->total_score}}</h6></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <div class="topper rank-one">
                                    @if ($allTime_rank1->user->image !== NULL && $allTime_rank1->user->image !== '')
                                        <div class="topper-img">
                                            <a href="{{route('friend.page',['slug'=>$allTime_rank1->user->slug])}}" title="{{($allTime_rank1->user->name)}}"><img src="{{asset('images/users/'.$allTime_rank1->user->image)}}" class="img-fluid top-player-img rank-one-img" alt="{{($allTime_rank1->user->name)}}"></a>
                                            <span class="badge rank-one-badge">{{__('1')}}</span>
                                        </div>
                                    @else
                                        <div class="topper-img">
                                            <a href="{{route('friend.page',['slug'=>$allTime_rank1->user->slug])}}" title="{{ $allTime_rank1->user->name }}"><img src="{{ Avatar::create($allTime_rank1->user->name)->toBase64() }}" class="img-fluid top-player-img rank-one-img" alt="{{ $allTime_rank1->user->name }}"></a>
                                            <span class="badge rank-one-badge">{{__('1')}}</span>
                                        </div>
                                    @endif
                                    <div class="topper-dtls">
                                        <a href="{{route('friend.page',['slug'=>$allTime_rank1->user->slug])}}" title="{{($allTime_rank1->user->name)}}"><h4 class="topper-name">{{($allTime_rank1->user->name)}}</h4></a>
                                        <a href="{{route('friend.page',['slug'=>$allTime_rank1->user->slug])}}" title="{{($allTime_rank1->user->name)}}"><h6 class="topper-score">{{($allTime_rank1->total_score)}}</h6></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <div class="topper runner-up">
                                    @if ($allTime_rank3->user->image !== NULL && $allTime_rank3->user->image !== '')
                                        <div class="topper-img">
                                            <a href="{{route('friend.page',['slug'=>$allTime_rank3->user->slug])}}" title="{{($allTime_rank3->user->name)}}"><img src="{{asset('images/users/'.$allTime_rank3->user->image)}}" class="img-fluid top-player-img runner-up-img" alt="{{($allTime_rank3->user->name)}}"></a>
                                            <span class="badge runner-up-badge">{{__('3')}}</span>
                                        </div>
                                    @else
                                        <div class="topper-img">
                                            <a href="{{route('friend.page',['slug'=>$allTime_rank3->user->slug])}}" title="{{ $allTime_rank3->user->name }}"><img src="{{ Avatar::create($allTime_rank3->user->name)->toBase64() }}" class="img-fluid top-player-img runner-up-img" alt="{{ $allTime_rank3->user->name }}"></a>
                                            <span class="badge runner-up-badge">{{__('3')}}</span>
                                        </div>
                                    @endif
                                    <div class="topper-dtls">
                                        <a href="{{route('friend.page',['slug'=>$allTime_rank3->user->slug])}}" title="{{($allTime_rank3->user->name)}}"><h4 class="topper-name">{{($allTime_rank3->user->name)}}</h4></a>
                                        <a href="{{route('friend.page',['slug'=>$allTime_rank3->user->slug])}}" title="{{($allTime_rank3->user->name)}}"><h6 class="topper-score">{{($allTime_rank3->total_score)}}</h6></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    @foreach($allTime_rest as $data)
                                    <tr>
                                        <td width="10%">{{$data->user->rank}}</td>
                                        <td width="30%">
                                            @if ($data->user->image !== NULL && $data->user->image !== '')
                                                <a href="{{route('friend.page',['slug'=>$data->user->slug])}}" title="{{$data->user->name}}"><img src="{{asset('images/users/'.$data->user->image)}}" class="img-fluid player-img" alt="{{$data->user->name}}"></a>
                                            @else
                                                <a href="{{route('friend.page',['slug'=>$data->user->slug])}}" title="{{ $data->user->image }}"><img src="{{ Avatar::create($data->user->image)->toBase64() }}" class="img-fluid" alt="{{ $data->user->image }}"></a>
                                            @endif
                                        </td>
                                        <td width="30%s"><a href="{{route('friend.page',['slug'=>$data->user->slug])}}" title="{{$data->user->name}}"><h5 class="player-name">{{$data->user->name}}</h5></a></td>
                                        <td width="30%">{{$data->total_score}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination">
                            {{ $allTime_rest->links() }}
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <h2 class="no-quiz ">{{__('No one had played quiz yet')}}</h2>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane fade " id="pills-monthly" role="tabpanel" aria-labelledby="pills-monthly-tab" tabindex="1">
                        <div class="leaderboard-toppers">
                            @if($monthly_rank2 != NULL && $monthly_rank1 != NULL && $monthly_rank2 != NULL && $monthly_rest != NULL)
                            <div class="row">
                                <div class="col-lg-4 text-center">
                                    <div class="topper runner-up">
                                        @if ($monthly_rank2->user->image !== NULL && $monthly_rank2->user->image !== '')
                                            <div class="topper-img">
                                                <a href="{{route('friend.page',['slug'=>$monthly_rank2->user->slug])}}" title="{{$monthly_rank2->user->name}}"><img src="{{asset('images/users/'.$monthly_rank2->user->image)}}" class="img-fluid top-player-img runner-up-img" alt="{{$monthly_rank2->user->name}}"></a>
                                                <span class="badge runner-up-badge">{{__('2')}}</span>
                                            </div>
                                        @else
                                            <div class="topper-img">
                                                <a href="{{route('friend.page',['slug'=>$monthly_rank2->user->slug])}}" title="{{ $monthly_rank2->user->name }}"><img src="{{ Avatar::create($monthly_rank2->user->name)->toBase64() }}" class="img-fluid top-player-img runner-up-img" alt="{{ $monthly_rank2->user->name }}"></a>
                                                <span class="badge runner-up-badge">{{__('2')}}</span>
                                            </div>
                                        @endif
                                        <div class="topper-dtls">
                                            <a href="{{route('friend.page',['slug'=>$monthly_rank2->user->slug])}}" title="{{$monthly_rank2->user->name}}"><h4 class="topper-name">{{$monthly_rank2->user->name}}</h4></a>
                                            <a href="{{route('friend.page',['slug'=>$monthly_rank2->user->slug])}}" title="{{$monthly_rank2->user->name}}"><h6 class="topper-score">{{$monthly_rank2->total_score}}</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="topper rank-one">
                                        @if ($monthly_rank1->user->image !== NULL && $monthly_rank1->user->image !== '')
                                            <div class="topper-img">
                                                <a href="{{route('friend.page',['slug'=>$monthly_rank1->user->slug])}}" title="{{$monthly_rank1->user->name}}"><img src="{{asset('images/users/'.$monthly_rank1->user->image)}}" class="img-fluid top-player-img rank-one-img" alt="{{$monthly_rank1->user->name}}"></a>
                                                <span class="badge rank-one-badge">{{__('1')}}</span>
                                            </div>
                                        @else
                                            <div class="topper-img">
                                                <a href="{{route('friend.page',['slug'=>$monthly_rank1->user->slug])}}" title="{{ $monthly_rank1->user->name }}"><img src="{{ Avatar::create($monthly_rank1->user->name)->toBase64() }}" class="img-fluid top-player-img rank-one-img" alt="{{ $monthly_rank1->user->name }}"></a>
                                                <span class="badge rank-one-badge">{{__('1')}}</span>
                                            </div>
                                        @endif
                                        <div class="topper-dtls">
                                            <a href="{{route('friend.page',['slug'=>$monthly_rank1->user->slug])}}" title="{{$monthly_rank1->user->name}}"><h4 class="topper-name">{{$monthly_rank1->user->name}}</h4></a>
                                            <a href="{{route('friend.page',['slug'=>$monthly_rank1->user->slug])}}" title="{{$monthly_rank1->user->name}}"><h6 class="topper-score">{{$monthly_rank1->total_score}}</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="topper runner-up">
                                        @if ($monthly_rank3->user->image !== NULL && $monthly_rank1->user->image !== '')
                                        <div class="topper-img">
                                            <a href="{{route('friend.page',['slug'=>$monthly_rank3->user->slug])}}" title="{{$monthly_rank3->user->name}}"><img src="{{asset('images/users/'.$monthly_rank3->user->image)}}" class="img-fluid top-player-img runner-up-img" alt="{{$monthly_rank3->user->name}}"></a>
                                            <span class="badge runner-up-badge">{{__('3')}}</span>
                                        </div>
                                        @else
                                            <div class="topper-img">
                                                <a href="{{route('friend.page',['slug'=>$monthly_rank3->user->slug])}}" title="{{ $monthly_rank3->user->name }}"><img src="{{ Avatar::create($monthly_rank3->user->name)->toBase64() }}" class="img-fluid top-player-img rank-one-img" alt="{{ $monthly_rank3->user->name }}"></a>
                                                <span class="badge rank-one-badge">{{__('3')}}</span>
                                            </div>
                                        @endif
                                        <div class="topper-dtls">
                                            <a href="{{route('friend.page',['slug'=>$monthly_rank3->user->slug])}}" title="{{$monthly_rank3->user->name}}"><h4 class="topper-name">{{$monthly_rank3->user->name}}</h4></a>
                                            <a href="{{route('friend.page',['slug'=>$monthly_rank3->user->slug])}}" title="{{$monthly_rank3->total_score}}"><h6 class="topper-score">{{$monthly_rank3->total_score}}</h6></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    @php
                                        $counter = 4;
                                    @endphp
                                    @foreach($monthly_rest as $data)
                                    <tr>
                                        <td  width="10%">{{$counter++}}</td>
                                        <td  width="30%">
                                            @if ($data->user->image !== NULL && $data->user->image !== '')
                                                <a href="{{route('friend.page',['slug'=>$data->user->slug])}}" title="{{$data->user->name}}"><img src="{{asset('images/users/'.$data->user->image)}}" class="img-fluid player-img" alt="{{$data->user->name}}"></a>
                                            @else
                                                <a href="{{route('friend.page',['slug'=>$data->user->slug])}}" title="{{ $data->user->image }}"><img src="{{ Avatar::create($data->user->image)->toBase64() }}" class="img-fluid" alt="{{ $data->user->image }}"></a>
                                            @endif
                                        </td>
                                        <td  width="30%"><a href="{{route('friend.page',['slug'=>$data->user->slug])}}" title="{{$data->user->name}}"><h5 class="player-name">{{$data->user->name}}</h5></a></td>
                                        <td  width="30%">{{$data->total_score}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <h2 class="no-quiz ">{{__('No one played quiz this month')}}</h2>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane fade" id="pills-today" role="tabpanel" aria-labelledby="pills-today-tab" tabindex="2">
                        <div class="leaderboard-toppers">
                            @if($today_rank2 != NULL && $today_rank1 != NULL && $today_rank3 != NULL && $today_rest != NULL)
                            <div class="row">

                                <div class="col-lg-4 text-center">
                                    <div class="topper runner-up">
                                        @if ($today_rank2->user->image !== NULL && $today_rank2->user->image !== '')
                                        <div class="topper-img">
                                            <a href="{{route('friend.page',['slug'=>$today_rank2->user->slug])}}" title="{{$today_rank2->user->name}}"><img src="{{asset('images/users/'.$today_rank2->user->image)}}" class="img-fluid top-player-img runner-up-img" alt="{{$today_rank2->user->name}}"></a>
                                            <span class="badge runner-up-badge">{{__('2')}}</span>
                                        </div>
                                        @else
                                            <div class="topper-img">
                                                <a href="{{route('friend.page',['slug'=>$today_rank2->user->slug])}}" title="{{ $today_rank2->user->name }}"><img src="{{ Avatar::create($today_rank2->user->name)->toBase64() }}" class="img-fluid top-player-img rank-one-img" alt="{{ $today_rank2->user->name }}"></a>
                                                <span class="badge runner-up-badge">{{__('2')}}</span>
                                            </div>
                                        @endif
                                        <div class="topper-dtls">
                                            <a href="{{route('friend.page',['slug'=>$today_rank2->user->slug])}}" title="{{$today_rank2->user->name}}"><h4 class="topper-name">{{$today_rank2->user->name}}</h4></a>
                                            <a href="{{route('friend.page',['slug'=>$today_rank2->user->slug])}}" title="{{$today_rank2->user->name}}"><h6 class="topper-score">{{$today_rank2->total_score}}</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="topper rank-one">
                                        @if ($today_rank1->user->image !== NULL && $today_rank1->user->image !== '')
                                        <div class="topper-img">
                                            <a href="{{route('friend.page',['slug'=>$today_rank1->user->slug])}}" title="{{$today_rank1->user->name}}"><img src="{{asset('images/users/'.$today_rank1->user->image)}}" class="img-fluid top-player-img rank-one-img" alt="{{$today_rank1->user->name}}"></a>
                                            <span class="badge rank-one-badge">{{__('1')}}</span>
                                        </div>
                                        @else
                                            <div class="topper-img">
                                                <a href="{{route('friend.page',['slug'=>$today_rank1->user->slug])}}" title="{{ $today_rank1->user->name }}"><img src="{{ Avatar::create($today_rank1->user->name)->toBase64() }}" class="img-fluid top-player-img rank-one-img" alt="{{ $today_rank1->user->name }}"></a>
                                                <span class="badge rank-one-badge">{{__('1')}}</span>
                                            </div>
                                        @endif
                                        <div class="topper-dtls">
                                            <a href="{{route('friend.page',['slug'=>$today_rank1->user->slug])}}" title="{{$today_rank1->user->name}}"><h4 class="topper-name">{{$today_rank1->user->name}}</h4></a>
                                            <a href="{{route('friend.page',['slug'=>$today_rank1->user->slug])}}" title="{{$today_rank1->user->name}}"><h6 class="topper-score">{{$today_rank1->total_score}}</h6></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="topper runner-up">
                                        @if ($today_rank3->user->image !== NULL && $today_rank3->user->image !== '')
                                        <div class="topper-img">
                                            <a href="{{route('friend.page',['slug'=>$today_rank3->user->slug])}}" title="{{$today_rank3->user->name}}"><img src="{{asset('images/users/'.$today_rank3->user->image)}}" class="img-fluid top-player-img runner-up-img" alt="{{$today_rank3->user->name}}"></a>
                                            <span class="badge runner-up-badge">{{__('3')}}</span>
                                        </div>
                                        @else
                                            <div class="topper-img">
                                                <a href="{{route('friend.page',['slug'=>$today_rank3->user->slug])}}" title="{{ $today_rank3->user->name }}"><img src="{{ Avatar::create($today_rank3->user->name)->toBase64() }}" class="img-fluid top-player-img rank-one-img" alt="{{ $today_rank3->user->name }}"></a>
                                                <span class="badge runner-up-badge">{{__('3')}}</span>
                                            </div>
                                        @endif
                                        <div class="topper-dtls">
                                            <a href="{{route('friend.page',['slug'=>$today_rank3->user->slug])}}" title="{{$today_rank3->user->name}}"><h4 class="topper-name">{{$today_rank3->user->name}}</h4></a>
                                            <a href="{{route('friend.page',['slug'=>$today_rank3->user->slug])}}" title="{{$today_rank3->user->name}}"><h6 class="topper-score">{{$today_rank3->total_score}}</h6></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    @php
                                        $counter = 4;
                                    @endphp
                                    @foreach($today_rest as $data)
                                    <tr>
                                        <td width="10%">{{$counter++}}</td>
                                        <td width="30%">
                                            @if ($data->user->image !== NULL && $data->user->image !== '')
                                                <a href="{{route('friend.page',['slug'=>$data->user->slug])}}" title="{{$data->user->name}}"><img src="{{asset('images/users/'.$data->user->image)}}" class="img-fluid player-img" alt="{{$data->user->name}}"></a>
                                            @else
                                                <a href="{{route('friend.page',['slug'=>$data->user->slug])}}" title="{{ $data->user->image }}"><img src="{{ Avatar::create($data->user->image)->toBase64() }}" class="img-fluid" alt="{{ $data->user->image }}"></a>
                                            @endif
                                        </td>
                                        <td width="30%"><a href="{{route('friend.page',['slug'=>$data->user->slug])}}" title=""><h5 class="player-name">{{$data->user->name}}</h5></a></td>
                                        <td width="30%">{{$data->total_score}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="row">3333333
                            <div class="col-lg-12 text-center">
                                <h2 class="no-quiz ">{{__('No one played quiz today')}}</h2>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
