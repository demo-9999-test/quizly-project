@extends('front.layouts.master')
@section('title', 'Play Quiz')
@section('content')
<section id="waiting" class="waiting-main-block">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <h2>{{__('Waiting for Opponent')}}</h2>
                <p>{{__('Opponent is still playing. Please wait until they submit the quiz...')}}</p>
            </div>
        </div>
        <div id="refresh-status"></div>
    </div>
</section>
<script>
function checkOpponentStatus() {
    fetch('{{ route("battle.check_status", ["battle_id" => $battle->id, "quiz_slug" => $quiz_slug, "user_slug" => $user_slug]) }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'redirect') {
            window.location.reload();
        } else {
            document.getElementById('refresh-status').textContent = 'Last checked: ' + new Date().toLocaleTimeString();
            setTimeout(checkOpponentStatus, 1000);
        }
    });
}
checkOpponentStatus();
</script>
@endsection
