<!DOCTYPE html>
<html>
<head>
    <title>{{__('Invoice')}}</title>
</head>
<body>
    <div class="row mb_30">
        <div class="col-lg-2">
            @if($invoice->show_logo == 1)
                <img src="{{ public_path('images/invoice/logo/'.$invoice->logo) }}" class="img-fluid" alt="logo">
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="invoice-block">
                <h5 class="invoice-heading mb_30">{{$invoice->header_message}}</h5>
                <div class="row mb_30">
                    <div class="col-lg-4">
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
                    <div class="col-lg-4">
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
                    <div class="col-lg-4">
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
</body>
</html>
