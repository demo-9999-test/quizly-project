@extends('admin.layouts.master')
@section('title', 'Badge Reports')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
        @slot('heading')
            {{ __('Badge Reports') }}
        @endslot
        @slot('menu1')
            {{ __('Badge Reports') }}
        @endslot
    @endcomponent

    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <!-- Badge Cards -->
            <div class="col-lg-12">
                <div class="row">
                    @foreach($badges as $data)
                    <div class="col-md-4">
                        <div class="badge-report-block">
                            <div class="badge-report-img">
                                @if (!empty($data->image))
                                    <img src="{{ asset('images/badge/'.$data->image) }}" class="img-fluid" alt="{{ $data->name }}">
                                @else
                                    <img src="{{ Avatar::create($data->name)->toBase64() }}" alt="{{ __('Badge img') }}">
                                @endif
                            </div>
                            <div class="badge-report-dtls">
                                <h5 class="badge-report-title">{{ $data->name }}</h5>
                                <p class="badge-report-txt">{{ $data->description }}</p>
                                <ul class="badge-report-lst">
                                    <li><strong>{{ __('Score: ') }}</strong> {{ $data->score }}</li>
                                    <li>
                                        <strong>{{ __('Status: ') }}</strong>
                                        @if($data->status == 1)
                                            <span class="active-txt">{{ __('Active') }}</span>
                                        @else
                                            <span class="inactive-txt">{{ __('Inactive') }}</span>
                                        @endif
                                    </li>
                                </ul>
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#badgeModal{{ $data->id }}">
                                            {{ __('View Users') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Users with this Badge -->
                    <div class="modal quiz-report-modal fade" id="badgeModal{{ $data->id }}" tabindex="-1" aria-labelledby="badgeModalLabel{{ $data->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="badgeModalLabel{{ $data->id }}">{{ 'Users with ' . $data->name . ' Badge' }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if($data->users->isEmpty())
                                        <p>{{ __('No users have been assigned this badge yet.') }}</p>
                                    @else
                                        <div class="quiz-type-users">
                                            @foreach($data->users as $user)
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-lg-2">
                                                        @if (!empty($user->image))
                                                            <img src="{{ asset('images/users/'.$user->image) }}" class="img-fluid widget-img" alt="{{ $user->name }}">
                                                        @else
                                                            <img src="{{ Avatar::create($user->name)->toBase64() }}" alt="{{ $user->name }}">
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-10">
                                                        <h5 class="quiz-type-title">{{ $user->name }}</h5>
                                                        <h6 class="quiz-type-email">({{ $user->email }})</h6>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
