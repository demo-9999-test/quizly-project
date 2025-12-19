@extends('front.layouts.master')
@section('title', 'Quizly | Set Battle')

@section('content')
<!-- Breadcrumb -->
<div id="breadcrumb" class="breadcrumb-main-block" style="background-image: url('{{ asset('images/breadcrumb/'.$setting->breadcrumb_img) }}')">
    <div class="overlay-bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <h2 class="breadcrumb-title mb_30">{{ __('Battle') }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{ __('Battle') }}</li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Set Battle Section -->
<section id="set-battle" class="set-battle-main-block">
    <div class="container">
        <div class="section text-center">
            <h3 class="section-title">Welcome to <span>{{ $mode->name }}</span> friendly battle arena</h3>
            <p class="section-txt">{{ __('Here you can either create a new room to challenge your friends or join an existing room to participate in a battle. Use the options below to get started!') }}</p>
        </div>
        <hr>
        <div class="row mb_30">
            <div class="col-lg-8 col-md-8">
                <div class="mode-dtls">
                    {!! $mode->description !!}
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <!-- Battle Image -->
                <div class="set-battle-img mb_30">
                    <img src="{{ asset('images/battle/'.$mode->image) }}" class="img-fluid" alt="">
                </div>
                <hr>

                <!-- Create Room -->
                <div class="room-card mb_30">
                    <h4 class="room-card-title">{{ __('Create Room') }}</h4>
                    <form action="{{ route('invite.user') }}" method="POST" id="inviteForm" class="room-card-form">
                        @csrf
                        <input type="hidden" name="battle_id" value="{{ $mode->id }}">
                        <input type="hidden" name="code" id="code">

                        <div class="row mb_20">
                            <div class="col-lg-8">
                                <label class="form-label">{{ __('Room Name') }}</label>
                                <input type="text" class="form-control" name="room_name" required>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">{{ __('Bid Amount') }}</label>
                                <input type="number" class="form-control" name="bid_amount" required>
                            </div>
                        </div>

                        <div class="col-lg-12 mb_20">
                            <label class="form-label">{{ __('Select Quiz') }}</label>
                            <select name="quiz_id" class="form-control" required>
                                <option value="" disabled selected>{{ __('Choose a quiz') }}</option>
                                @foreach($quiz as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="button" class="btn btn-warning" onclick="generateCode()">{{ __('Generate Code') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Create Room') }}</button>

                        <div class="code-section mt-3" id="codeSection" style="display:none;">
                            <p><strong>{{ __('Room Code: ') }}</strong> <span id="roomCode"></span></p>
                            <button type="button" class="btn btn-secondary copy-code-btn" onclick="copyCode()">{{ __('Copy Code') }}</button>
                        </div>
                    </form>
                </div>

                <!-- Join Room -->
                <div class="room-card">
                    <h4 class="room-card-title">{{ __('Join a Room') }}</h4>
                    <form action="{{ route('join.user') }}" method="POST" class="room-card-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('Room Code') }}</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Join Room') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function generateCode() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let code = '';
        for (let i = 0; i < 6; i++) {
            code += characters.charAt(Math.floor(Math.random() * characters.length));
        }

        document.getElementById('roomCode').innerText = code;
        document.getElementById('code').value = code;
        document.getElementById('codeSection').style.display = 'block';
    }

    function copyCode() {
        const code = document.getElementById('roomCode').innerText;
        if (!code) return;
        navigator.clipboard.writeText(code).then(() => {
            const btn = document.querySelector('.copy-code-btn');
            btn.innerText = "Copied!";
            setTimeout(() => btn.innerText = "Copy Code", 2000);
        });
    }
</script>
@endsection
