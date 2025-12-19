@extends('admin.layouts.master')
@section('title', 'Subscriber List')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['secondaryactive' => 'active'])
        @slot('heading')
        {{ __('Subscriber List') }}
        @endslot
        @slot('menu1')
        {{ __('Subscriber List') }}
        @endslot
    @endcomponent
    <!-- Breadcrumb Start -->

    <!-- Breadcrumb End -->
    <div class="contentbar">
        @include('admin.layouts.flash_msg');
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block user-page">
                    <div class="table-responsive">
                        <!-- Table start-->
                        <table class="table display" id="example">
                            <thead>
                                <tr>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscribers as $request)
                                    <tr>
                                        <td>{{ $request->email }}</td>

                                        <td>{{ $request->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Table end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

