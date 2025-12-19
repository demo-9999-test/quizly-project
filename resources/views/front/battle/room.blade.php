@extends('front.layouts.master')
@section('title', 'Quizly | Set Battle')
@section('content')
<section id="battleroom" class="battleroom-main-block">
    <div class="container">
        <div class="battle-room mb_30">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="player-room-dtls">
                        <h2 class="  mb_10">{{ 'Battle Room:' . $battle->room_name }}</h2>
                        <p class="">{{__('Room Code: ')}} <strong>{{ $battle->code }}</strong></p>
                        <p class="">{{__('Bid Amount: ')}} <strong>{{ $battle->bid_amount }}</strong></p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <h3 class="player-id text-center mb_20">{{__('You')}}</h3>
                    <div class="play-card-block text-center">
                        @if(auth()->id() === $battle->creator_id)
                            @if(!is_null($creator->image) && $creator->image !== '')
                            <div class="player-card-image" style="background-color: {{ $creatorBannerColor }}">
                                <img src="{{ asset('/images/users/' . $creator->image) }}" class="img-fluid" alt="{{ $creator->name }}">
                            </div>
                            @else
                            <div class="player-card-image" style="background-color: {{ $creatorBannerColor }}">
                                <img src="{{ Avatar::create($creator->name)->toBase64() }}" class="img-fluid" alt="{{ $creator->name }}">
                            </div>
                            @endif
                            <div class="player-card-details">
                                <h4 class="player-card-name">{{__('Name: ')}} {{ $creator->name }}</h4>
                                <h6 class="player-card-email">{{__('Email: ')}} {{ $creator->email }}</h6>
                                <hr>
                                <ul class="play-card-lst">
                                    <li>{{'Score: '.$creator->score}}</li>
                                    <li>{{'Rank: '.$creator->rank}}</li>
                                </ul>
                            </div>
                        @else
                            @if(!is_null(auth()->user()->image) && auth()->user()->image !== '')
                            <div class="player-card-image" style="background-color: {{ $opponentBannerColor }}">
                                <img src="{{ asset('/images/users/' . auth()->user()->image) }}" class="img-fluid" alt="{{ auth()->user()->name }}">
                            </div>
                            @else
                            <div class="player-card-image" style="background-color: {{ $opponentBannerColor }}">
                                <img src="{{ Avatar::create(auth()->user()->name)->toBase64() }}" class="img-fluid" alt="{{ auth()->user()->name }}">
                            </div>
                            @endif
                            <div class="player-card-details">
                                <h4 class="player-card-name">{{__('Name: ')}} {{ auth()->user()->name }}</h4>
                                <h6 class="player-card-email">{{__('Email: ')}} {{ auth()->user()->email }}</h6>
                                <hr>
                                <ul class="play-card-lst">
                                    <li>{{'Score: '.auth()->user()->score}}</li>
                                    <li>{{'Rank: '.auth()->user()->rank}}</li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="offset-lg-2 col-md-2 d-flex justify-content-center align-items-center">
                    <h2 class="vs-text">{{__('VS')}}</h2>
                </div>
                <div class="offset-lg-2 col-md-3">
                    <h3 class="player-id text-center mb_20">{{__('Opponent')}}</h3>
                    @if($battle->opponent_id)
                        @php
                            $opponent = auth()->id() === $battle->creator_id ? $battle->opponent : $battle->creator;
                        @endphp
                        <div class="play-card-block text-center">
                            @if(!is_null($opponent->image) && $opponent->image !== '')
                            <div class="player-card-image" style="background-color: {{ $opponentBannerColor }}">
                                <img src="{{ asset('images/users/' . $opponent->image) }}" class="img-fluid" alt="{{ $opponent->name }}">
                            </div>
                            @else
                            <div class="player-card-image" style="background-color: {{ $opponentBannerColor }}">
                                <img src="{{ Avatar::create($opponent->name)->toBase64() }}" class="img-fluid" alt="{{ $opponent->name }}">
                            </div>
                            @endif
                            <div class="player-card-details">
                                <h4 class="player-card-name">{{__('Name: ')}} {{ $opponent->name }}</h4>
                                <h6 class="player-card-email">{{__('Email: ')}} {{ $opponent->email }}</h6>
                                <hr>
                                <ul class="play-card-lst">
                                    <li>{{'Score: '.$opponent->score}}</li>
                                    <li>{{'Rank: '.$opponent->rank}}</li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <h4 class="waiting-title">{{ __('Waiting for opponent...') }}</h4>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="offset-lg-4 col-lg-4">
                <div class="battle-quiz-block">
                    @if(!is_null($quiz->image) && $quiz->image !== '')
                    <img src="{{asset('images/quiz/'.$quiz->image)}}" class="img-fluid" alt="{{ $quiz->name }}">
                    @else
                    <img src="{{ Avatar::create($quiz->name)->toBase64() }}" class="img-fluid" alt="{{ $quiz->name }}">
                    @endif
                    <div class="battle-quiz-dtls text-center">
                        <h3 class="battle-quiz-name">{{$quiz->name}}</h3>
                        <p class="battle-quiz-txt mb_20">{{$quiz->description}}</p>
                        @if(!$battle->opponent_id )
                            <div class="battle-quiz-info text-center">
                                <p>{{__('Battle will start automatically when opponent join room')}}</p>
                            </div>
                        @else
                        <div class="battle-quiz-info text-center">
                            <p id="countdown">{{__('Battle will start within: '.$battle_type->room_time.' seconds')}}</p>
                        </div>
                        @endif
                    </div>
                    <!-- Here this script needs for counting timeLeft of battle  -->
                    <script>
                        let timeLeft = {{ $battle_type->room_time }};
                            let countdownTimer = setInterval(function() {
                            if (timeLeft <= 0) {
                                clearInterval(countdownTimer);
                                document.getElementById("countdown").innerHTML = "Battle starting...";

                                // Call the route to start the battle
                                window.location.href = "{{ route('start.battle', ['battle_id' => $battle->id, 'quiz_id' => $quiz->id]) }}";
                            } else {
                                document.getElementById("countdown").innerHTML = "Battle will start within: " + timeLeft + " seconds";
                            }
                            timeLeft -= 1;
                        }, 1000);
                    </script>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
