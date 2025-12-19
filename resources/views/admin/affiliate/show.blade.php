@extends('admin.layouts.master')
@section('title', 'Affiliate Link')
@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Affiliate Link') }}
    @endslot
    @slot('menu1')
    {{ __('Affiliate') }}
    @endslot
    @slot('menu2')
    {{ __('Affiliate Link') }}
    @endslot
    @endcomponent

    <div class="contentbar profile-main-block">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!--form code start-->
                <div class="row">
                    <div class="col-lg-8 col-md-7">
                        <div class="client-detail-block affiliate-dashboard-card">
                            <h5 class="card-title mb-1">{{ __('Start refering your friends and start earning !!') }}
                            </h5>
                            <p class="card-text mb-4">
                                {{ __('This is your unique refer link share with your friends and family and start
                                earning !') }}
                            </p>
                            @auth
                            <div class="input-group">
                                <input type="text" id="myInput" class="form-control form-control-padding_15"
                                value="{{ url('/register') . '/?ref=' . Auth::user()->affiliate_id }}" readonly>
                                <div class="input-group-append refer-btn">
                                    <button onclick="myFunction()" class="btn btn-primary" title="{{ __('Copy') }}"
                                    type="button"><i class="flaticon-copy me-2"></i>{{ __('Copy') }}</button>
                                </div>
                            </div>
                            @endauth
                            @if(auth()->user()->affiliate_id == NULL)
                            <form id="mainform" action="{{ route('generate.affiliate') }}" method="POST">
                                @csrf
                                <button type="submit" class="pull-left btn btn-primary"
                                    title=" {{ __('Generate Affiliate Link') }}">
                                    {{ __('Generate Affiliate Link') }}
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5">
                        <div class="client-detail-block">
                            <div class="qr-code-block text-center">
                                <div class="card-body">
                                    <h5 class="qr-code-title mb-3">{{__('Scan QR Code')}}</h5>
                                    <?php
                                    $path= url('/register') . '/?ref=' . Auth::user()->affiliate_id;
                                ?>
                                    {!! QrCode::size(200)->generate($path) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
