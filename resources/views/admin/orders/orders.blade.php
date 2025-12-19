@extends('admin.layouts.master')
@section('title', 'Orders')
@section('main-container')
    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
            @slot('heading')
                {{ __('Orders') }}
            @endslot
            @slot('menu1')
                {{ __('Orders') }}
            @endslot
        @endcomponent
        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12">
                    <div class="client-detail-block">
                        <div class="table-responsive">
                            <!--Table Start-->
                            <table class="table data-table table-borderless" id="example">
                                <thead>
                                    <tr>
                                        <th>{{__('#')}}</th>
                                        <th>{{__('Image')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Amount')}}</th>
                                        <th>{{__('Currency')}}</th>
                                        <th>{{__('Package')}}</th>
                                        <th>{{__('Coupon')}}</th>
                                        <th>{{__('Method')}}</th>
                                        <th>{{__('Time')}}</th>
                                        <th>{{__('Status')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter =1;
                                    @endphp
                                    @foreach ($order as $data )
                                    <tr>
                                        <td>
                                            {{$counter++}}
                                        </td>
                                        <td>
                                            @if (!empty($data->user->image))
                                                <img src="{{asset('images/users/'.$data->user->image)}}" class="img-fluid widget-img " alt="{{$data->user->image}}">
                                                @else
                                               <img src="{{ Avatar::create($data->user->image)->toBase64() }}"  alt=" {{$data->user->name}}">
                                            @endif 
                                        </td>
                                        <td>
                                            {{$data->user->name}}
                                        </td>
                                        <td>
                                            {{$data->total_amount}}
                                        </td>
                                        <td>{{$data->currency_name . '('.$data->currency_icon.')'}}</td>
                                        <td>
                                            {{$data->package->pname}}
                                        </td>
                                        <td>
                                            @if($data->coupon_discount == null)
                                                <span class="badge text-bg-danger">{{ __('No coupon applied') }}</span>
                                            @else
                                                @php
                                                    $coupon = App\Models\Coupon::find($data->coupon_discount);
                                                @endphp
                                                {{ $coupon->coupon_code ?? __('Coupon name not available') }}
                                            @endif
                                        </td>
                                        <td>
                                            {{$data->payment_method}}
                                        </td>
                                        <td>{{$data->created_at->diffForHumans()}}</td>
                                        <td>
                                            @if($data->status == 'success')
                                            <span class="badge text-bg-success">{{__('Success')}}</span>
                                            @elseif ($data->status == 'failed')
                                            <span class="badge text-bg-danger">{{__('Failed')}}</span>
                                            @else
                                            <span class="badge text-bg-warning">{{__('Pending')}}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="pagination">
                        {{ $order->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
