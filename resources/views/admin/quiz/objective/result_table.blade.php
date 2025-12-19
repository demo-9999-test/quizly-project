@extends('admin.layouts.master')
@section('title', 'Quiz')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
            @slot('heading')
                {{ __('Result table') }}
            @endslot
            @slot('menu1')
                {{ __('Result table') }}
            @endslot
            @slot('button')

                <div class="col-md-6 col-lg-6">
                    <div class="widget-button">

                        <a href="{{ route('quiz.index') }}" class="btn btn-primary" title="{{ __('Back') }}"><i class="flaticon-back"></i>{{ __('Back') }}</a>
                    </div>
                </div>
            @endslot
        @endcomponent
        
        <!-- Start Contentbar -->
        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="client-detail-block">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="table-responsive">
                                @php
                                    $counter = 1;
                                @endphp
                                <table class="table data-table display nowrap" id="example">
                                    <thead>
                                        <tr>
                                            <th>{{ __('#') }}</th>
                                            <th>{{ __('Image') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Attempted questions') }}</th>
                                            <th>{{ __('Skipped questions')}}</th>
                                            <th>{{ __('Check answers')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($answers as $userId => $data)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>
                                                    @if (!empty($data['user']->image))
                                                    <img src="{{ asset('/images/users/' . $data['user']->image) }}" alt="{{ __('user img') }}"
                                                        class="widget-img">
                                                    @else
                                                    <img src="{{ Avatar::create($data['user']->name)->toBase64() }}" />
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $data['user']->name }}
                                                </td>
                                                <td>
                                                    {{ $data['attempted'] }}
                                                </td>
                                                <td>
                                                    {{ $data['skipped'] }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('objective.result', ['id' => $id, 'user_id' => $data['user']->id]) }}" class="btn btn-success">{{ __('Check result') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contentbar -->
    </div>
@endsection
