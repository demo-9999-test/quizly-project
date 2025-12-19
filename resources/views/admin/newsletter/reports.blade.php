@extends('admin.layouts.master')
@section('title', 'Leaderboard')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
            @slot('heading')
                {{ __('Newsletter Reports') }}
            @endslot
            @slot('menu1')
                {{ __('Newsletter Reports') }}
            @endslot
        @endcomponent
        
        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-8">
                    <div class="client-detail-block">
                        <div class="table-responsive no-btn-table">
                            <!--Table Start-->
                            <table  class="table data-table table-borderless"  id="example">
                                <thead>
                                    <th>{{('#')}}</th>
                                    <th>{{__('Email')}}</th>
                                    <th>{{__('Status')}}</th>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach ($subscribers as $data )
                                    <tr>
                                        <td>
                                            {{$counter++}}
                                        </td>
                                        <td>
                                            {{$data->email}}
                                        </td>
                                        <td>
                                            {{$data->status}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="client-detail-block mb-4">
                                <h5 class="subsciber-count-title">
                                    {{__('Verified')}}
                                </h5>
                                <p class="subsciber-count-txt text-center">{{$activeStatus}}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="client-detail-block">
                                <h5 class="subsciber-count-title">
                                    {{__('Not Verified')}}
                                </h5>
                                <p class="subsciber-count-txt text-center">{{$nonactiveStatus}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
