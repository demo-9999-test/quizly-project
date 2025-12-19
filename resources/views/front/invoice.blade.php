@extends('front.layouts.master')
@section('title', 'Quizly | My Reports')
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
                    <h2 class="breadcrumb-title mb_30">{{__('Reports')}}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home.page')}}" title="{{__('Home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{__('Reports')}} </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<section id="invoice" class="invoice-main-block">
    <div class="container">
        <div class="row mb_30">
            <div class="col-lg-2 col-md-4">
                @if($invoice->show_logo == 1)
                    <img src="{{asset('images/invoice/logo/'.$invoice->logo)}}" class="img-fluid" alt="{{__('logo')}}">
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-block">
                    <h5 class="invoice-heading mb_30">{{$invoice->header_message}}</h5>
                    <div class="row mb_30">
                        <div class="col-lg-4 col-md-6">
                            <div class="invoice-info-block">
                                <h4 class="invoice-info-heading mb_10">{{__('From: ')}}{{$user->name}}</h4>
                                <p class="invoice-info-txt">
                                   <strong>{{__('Email: ')}}</strong>{{$user->email}}
                                </p>
                                <p class="invoice-info-txt">
                                    <strong>{{__('Phone: ')}}</strong>{{$user->mobile}}
                                 </p>
                                 <p class="invoice-info-txt">
                                    <strong>{{__('Location: ')}}</strong>{{$user->city. ',' . $user->state  }}
                                 </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="invoice-info-block">
                                <h4 class="invoice-info-heading mb_10">{{__('To: ')}}{{$invoice->site_name}}</h4>
                                <p class="invoice-info-txt">
                                   <strong>{{__('Email: ')}}</strong>{{$invoice->contact_email}}
                                </p>
                                <p class="invoice-info-txt">
                                    <strong>{{__('Phone: ')}}</strong>{{$invoice->contact_phone}}
                                 </p>
                                 <p class="invoice-info-txt">
                                    <strong>{{__('Location: ')}}</strong>{{$invoice->contact_address  }}
                                 </p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <p><strong>{{('Package: ')}}</strong> {{ $transaction->package->pname }}</p>
                            <p><strong>{{('Transaction ID: ')}}</strong> {{ $transaction->transaction_id }}</p>
                            <p><strong>{{('Date: ')}}</strong> {{ $transaction->created_at->format('d-m-Y') }}</p>
                            <p><strong>{{('Status: ')}}</strong> {{ $transaction->status }}</p>
                            <p><strong>{{('Amount: ')}}</strong> {{ $transaction->currency_icon }} {{ $transaction->total_amount }}</p>
                        </div>
                    </div>
                    <h5 class="invoice-heading">{{$invoice->footer_message}}</h5>
                </div>
            </div>
        </div>
        <a href="{{ route('invoice.download', ['user_slug' => $user->slug ,'transaction_id' => $transaction->transaction_id]) }}" class="btn btn-primary mt-3" title="{{__('Download PDF')}}">{{__('Download PDF')}}</a>
    </div>
</section>
@endsection
