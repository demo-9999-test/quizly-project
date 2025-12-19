@extends('admin.layouts.master')
@section('title', 'Quiz')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
            @slot('heading')
                {{ __('Quiz') }}
            @endslot
            @slot('menu1')
                {{ __('Quiz') }}
            @endslot
        @endcomponent

        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="quiz-tab reports-tabs">
                    <div class="nav nav-pills nav-tabs" id="v-pills-tab" role="tablist">
                        <a class="nav-link active" id="v-pills-quiz-tab" data-bs-toggle="pill"
                            href="#v-pills-quiz" type="button" title="{{__('Quiz')}}" role="tab" aria-controls="v-pills-quiz" aria-selected="true">
                            {{ __('Quiz') }}
                        </a>
                        <a class="nav-link" id="v-pills-participants-tab" data-bs-toggle="pill"
                            href="#v-pills-participants" title="{{__('Participants')}}" type="button" role="tab" aria-controls="v-pills-participants"
                            aria-selected="false">
                            {{ __('Participants') }}
                        </a>
                    </div>
                </div>

                <!-- Detailed Quiz Reports -->
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-quiz" role="tabpanel" aria-labelledby="v-pills-quiz-tab" tabindex="0">
                        <div class="client-detail-block">
                            <table class="table data-table table-borderless" id="example">
                                <thead>
                                    <tr>
                                        <th>{{__('#')}}</th>
                                        <th>{{__('Quiz Title')}}</th>
                                        <th>{{__('Timer')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Result')}}</th>
                                        <th>{{__('Start Date')}}</th>
                                        <th>{{__('End Date')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach ($quizReports as $report)
                                        <tr>
                                            <td>{{$counter++}}</td>
                                            <td>{{ $report['quiz']->name }}</td>
                                            <td>{{ $report['quiz']->timer }} {{__('minutes')}}</td>
                                            <td>
                                                @if($report['quiz']->status == 1)
                                                <span class="badge text-bg-success">{{__('Active')}}</span>
                                                @else
                                                <span class="badge text-bg-danger">{{__('Not active')}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($report['quiz']->approve_result == 1)
                                                <span class="badge text-bg-success">{{__('Declared')}}</span>
                                                @else
                                                <span class="badge text-bg-danger">{{__('Not Declared')}}</span>
                                                @endif
                                            </td>
                                            <td>{{ $report['quiz']->start_date }}</td>
                                            <td>{{ $report['quiz']->end_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-participants" role="tabpanel" aria-labelledby="v-pills-participants-tab" tabindex="1">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{__('Objective Quizzes')}}</h5>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>{{__('Quiz Title')}}</th>
                                                    <th>{{__('Participants')}}</th>
                                                    <th>{{__('Users')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($objectiveQuizzes as $quiz)
                                                    <tr>
                                                        <td>{{ $quiz->name }}</td>
                                                        <td>{{ $quiz->participants_count }}</td>
                                                        <td>
                                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#usersModal-{{ $quiz->id }}">
                                                                {{ __('View Users') }}
                                                            </button>
                                                            <div class="modal quiz-report-modal fade" id="usersModal-{{ $quiz->id }}" tabindex="-1" aria-labelledby="usersModalLabel-{{ $quiz->id }}" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="usersModalLabel-{{ $quiz->id }}">{{ __('Users for Quiz: ') }}{{ $quiz->name }}</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            @foreach ($quiz->objectiveAnswers->groupBy('user_id')->map->first() as $answer)
                                                                            <div class="quiz-type-users">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-lg-2">
                                                                                        <img src="{{asset('images/users/'.$answer->user->image)}}" class="img-fluid widget-img" alt="">
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <h5 class="quiz-type-title">
                                                                                            {{ $answer->user->name }}
                                                                                        </h5>
                                                                                        <h6 class="quiz-type-email">
                                                                                            ({{ $answer->user->email }})
                                                                                        </h6>
                                                                                    </div>
                                                                                    <div class="col-lg-4 text-end">
                                                                                        @if($answer->quiz->approve_result == 1)
                                                                                        <a href="{{ route('objective.result', ['id' => $answer->quiz->id, 'user_id' => $answer->user->id]) }}" class="btn btn-info" title="{{__('Check result')}}">{{__('Check result')}}</a>
                                                                                        @else
                                                                                        <p class="not-yet-txt">{{__('Result not declared yet')}}</p>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $objectiveQuizzes->appends(['objective_quizzes' => $objectiveQuizzes->currentPage()])->links() }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{__('Subjective Quizzes')}}</h5>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>{{__('Quiz Title')}}</th>
                                                    <th>{{__('Participants')}}</th>
                                                    <th>{{__('Users')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subjectiveQuizzes as $quiz)
                                                    <tr>
                                                        <td>{{ $quiz->name }}</td>
                                                        <td>{{ $quiz->participants_count }}</td>
                                                        <td>
                                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#usersModal-{{ $quiz->id }}">{{__('View Users')}}</button>
                                                            <div class="modal quiz-report-modal fade" id="usersModal-{{ $quiz->id }}" tabindex="-1" aria-labelledby="usersModalLabel-{{ $quiz->id }}" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="usersModalLabel-{{ $quiz->id }}">{{ 'Users for Quiz: '. $quiz->name }}</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <ul class="list-group">
                                                                                @foreach ($quiz->subjectiveAnswers->unique('user_id') as $answer)
                                                                                <div class="quiz-type-users">
                                                                                    <div class="row align-items-center">
                                                                                        <div class="col-lg-2">
                                                                                            <img src="{{asset('images/users/'.$answer->user->image)}}" class="img-fluid widget-img" alt="">
                                                                                        </div>
                                                                                        <div class="col-lg-6">
                                                                                            <h5 class="quiz-type-title">
                                                                                                {{ $answer->user->name }}
                                                                                            </h5>
                                                                                            <h6 class="quiz-type-email">
                                                                                                ({{ $answer->user->email }})
                                                                                            </h6>
                                                                                        </div>
                                                                                        <div class="col-lg-4 text-end">
                                                                                            @if($answer->quiz->approve_result == 1)
                                                                                            <a href="{{ route('subjective.result', ['id' => $answer->quiz->id, 'user_id' => $answer->user->id]) }}" class="btn btn-info" title="{{__('Check result')}}">{{__('Check result')}}</a>
                                                                                            @else
                                                                                            <p class="not-yet-txt">{{__('Result not declared yet')}}</p>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $subjectiveQuizzes->appends(['subjective_quizzes' => $subjectiveQuizzes->currentPage()])->links() }}
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
