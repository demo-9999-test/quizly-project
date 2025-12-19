@extends('admin.layouts.master')
@section('title', 'Quiz Import')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Quiz ') }}
    @endslot
    @slot('menu1')
    {{ __('Quiz ') }}
    @endslot
    @slot('menu2')
    {{ __('Import ') }}
    @endslot

    @slot('button')
    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('objective.index',['id'=>$quiz->id]) }}" class="btn btn-primary"><i class="flaticon-back"></i>
                {{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent

    <div class="contentbar user-import-block">
        @include('admin.layouts.flash_msg')
        <!-- Start Tab-button Code -->
            <div class="quiz-tab">
                <div class="nav nav-pills table-tabs" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
                    <a class="nav-link active" id="v-pills-mcq-tab" data-bs-toggle="pill"
                        href="#v-pills-mcq" type="button" role="tab" aria-controls="v-pills-mcq" aria-selected="true">
                        {{ __('Multiple Choice') }}
                    </a>
                    <a class="nav-link" id="v-pills-true_false-tab" data-bs-toggle="pill"
                        href="#v-pills-true_false" type="button" role="tab" aria-controls="v-pills-true_false"
                        aria-selected="false">
                        {{ __('True And False') }}
                    </a>
                    <a class="nav-link" id="v-pills-fill_blanks-tab" data-bs-toggle="pill"
                        href="#v-pills-fill_blanks" type="button" role="tab" aria-controls="v-pills-fill_blanks"
                        aria-selected="false">
                        {{ __('Fill in the blanks') }}
                    </a>
                    <a class="nav-link" id="v-pills-match_following-tab" data-bs-toggle="pill"
                        href="#v-pills-match_following" type="button" role="tab" aria-controls="v-pills-match_following"
                        aria-selected="false">
                        {{ __('Match The Following') }}
                    </a>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-mcq" role="tabpanel"
                        aria-labelledby="v-pills-mcq-tab" tabindex="0">
                        <div class="client-detail-block mb-4">
                            <div class="row">
                                <div class="col-lg-9 col-md-8">
                                    <h5> {{ __('Import MCQ') }}</h5>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <button onclick="downloadMCQCSV()" class="btn btn-primary float-lg-end float-md-end float-sm-start"
                                        title=" {{ __('Download Demo CSV') }}">
                                        {{ __('Download Demo CSV') }}
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="client-detail-block">
                                        <form action="{{route('objective.importMcq',['id' => $quiz->id])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <h5 class="block-heading"> {{ __('Import') }}</h5>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group mb-5">
                                                        <label for="" class="form-label"> {{ __('Select CSV File :') }}</label>
                                                        <div class="row">
                                                            <div class="col-lg-8 col-md-8 col-8">
                                                                <input class="form-control" type="file" name="file" accept=".csv" required>
                                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-4">
                                                                <div class="user-import-submit-btn">
                                                                    <button type="submit" title=" {{ __('Submit') }}"
                                                                        class="btn btn-primary">{{ __('Submit') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="table-responsive">
                                            <!--  Table start-->
                                            <table class="table data-table display nowrap" id="example">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Column No') }}</th>
                                                        <th>{{ __(' Column Name') }}</th>
                                                        <th>{{ __('Description') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><strong>{{ __('question') }}</strong> (Required)</td>
                                                        <td>{{ __('question') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td><strong>{{ __('option_a') }}</strong> (Required)</td>
                                                        <td>{{ __('option_a') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td><strong>{{ __('option_b') }}</strong> (Required)</td>
                                                        <td>{{ __('option_b') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td><strong>{{ __('option_c') }}</strong> (Required)</td>
                                                        <td> {{ __('option_c') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td><strong>{{ __('option_d') }}</strong> (Required)</td>
                                                        <td>{{ __('option_d') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td><strong> {{ __('correct_answer') }}</strong> (Required, Value: Option A, Option B, Option C or Option D)</td>
                                                        <td> {{ __('correct_answer') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td><strong> {{ __('image') }}</strong></td>
                                                        <td> {{ __('image') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>8</td>
                                                        <td><strong> {{ __('audio') }}</strong></td>
                                                        <td> {{ __('audio') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>9</td>
                                                        <td><strong> {{ __('video') }}</strong></td>
                                                        <td> {{ __('video') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10</td>
                                                        <td><strong> {{ __('mark') }}</strong>(Required)</td>
                                                        <td> {{ __('mark') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>11</td>
                                                        <td><strong> {{ __('ques_type') }}</strong>(Required, Determine question type! Choose any one : 'multiple_choice','true_false','fill_blank','match_following' )</td>
                                                        <td> {{ __('ques_type') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>12</td>
                                                        <td><strong> {{ __('quiz_id') }}</strong> (Required, default value:{{$quiz->id}})</td>
                                                        <td> {{ __('quiz_id') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            {{-- --------- Table end-------------------------- --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-true_false" role="tabpanel"
                            aria-labelledby="v-pills-true_false-tab" tabindex="0">
                        <div class="client-detail-block mb-4">
                            <div class="row">
                                <div class="col-lg-9 col-md-8">
                                    <h5> {{ __('Import True False') }}</h5>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <button onclick="downloadTrueFalseCSV()" class="btn btn-primary float-lg-end float-md-end float-sm-start"
                                        title=" {{ __('Download Demo CSV') }}">
                                        {{ __('Download Demo CSV') }}
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="client-detail-block">
                                        <form action="{{route('objective.importTrueFalse',['id' => $quiz->id])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <h5 class="block-heading"> {{ __('Import') }}</h5>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group mb-5">
                                                        <label for="" class="form-label"> {{ __('Select CSV File :') }}</label>
                                                        <div class="row">
                                                            <div class="col-lg-8 col-md-8 col-8">
                                                                <input class="form-control" type="file" name="file" accept=".csv" required>
                                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-4">
                                                                <div class="user-import-submit-btn">
                                                                    <button type="submit" title=" {{ __('Submit') }}"
                                                                        class="btn btn-primary">{{ __('Submit') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="table-responsive">
                                            <!--  Table start-->
                                            <table class="table data-table display nowrap" id="example">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Column No') }}</th>
                                                        <th>{{ __(' Column Name') }}</th>
                                                        <th>{{ __('Description') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><strong>{{ __('question') }}</strong> (Required)</td>
                                                        <td>{{ __('question') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td><strong>{{ __('option_a') }}</strong> (Required)</td>
                                                        <td>{{ __('option_a') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td><strong>{{ __('option_b') }}</strong> (Required)</td>
                                                        <td>{{ __('option_b') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td><strong>{{ __('correct_answer') }}</strong> (Required, Value: True or False)</td>
                                                        <td> {{ __('correct_answer') }}</td>
                                                    </tr>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td><strong>{{ __('image') }}</strong></td>
                                                    <td> {{ __('image') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td><strong>{{ __('audio') }}</strong></td>
                                                    <td> {{ __('audio') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td><strong>{{ __('video') }}</strong></td>
                                                    <td> {{ __('video') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td><strong> {{ __('mark') }}</strong>(Required)</td>
                                                    <td> {{ __('mark') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td><strong> {{ __('ques_type') }}</strong>(Required, Determine question type! Choose any one : 'multiple_choice','true_false','fill_blank','match_following' )</td>
                                                    <td> {{ __('ques_type') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td><strong> {{ __('quiz_id') }}</strong> (Required, default value:{{$quiz->id}})</td>
                                                    <td> {{ __('quiz_id') }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            {{-- --------- Table end-------------------------- --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-fill_blanks" role="tabpanel"
                        aria-labelledby="v-pills-fill_blanks-tab" tabindex="2">
                        <div class="client-detail-block mb-4">
                            <div class="row">
                                <div class="col-lg-9 col-md-8">
                                    <h5> {{ __('Import Fill in the balnks') }}</h5>
                                </div>
                                <div class="col-lg-3 col-md-4">
                                    <button onclick="downloadFillBlankCSV()" class="btn btn-primary float-lg-end float-md-end float-sm-start"
                                        title=" {{ __('Download Demo CSV') }}">
                                        {{ __('Download Demo CSV') }}
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="client-detail-block">
                                        <form action="{{route('objective.importFillBlank',['id' => $quiz->id])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <h5 class="block-heading"> {{ __('Import') }}</h5>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group mb-5">
                                                        <label for="" class="form-label"> {{ __('Select CSV File :') }}</label>
                                                        <div class="row">
                                                            <div class="col-lg-8 col-md-8 col-8">
                                                                <input class="form-control" type="file" name="file" accept=".csv" required>
                                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-4">
                                                                <div class="user-import-submit-btn">
                                                                    <button type="submit" title=" {{ __('Submit') }}"
                                                                        class="btn btn-primary">{{ __('Submit') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="table-responsive">
                                            <!--  Table start-->
                                            <table class="table data-table display nowrap" id="example">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('Column No') }}</th>
                                                        <th>{{ __(' Column Name') }}</th>
                                                        <th>{{ __('Description') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><strong>{{ __('question') }}</strong> (Required)</td>
                                                        <td>{{ __('question') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td><strong>{{ __('option_a') }}</strong> (Required)</td>
                                                        <td>{{ __('option_a') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td><strong>{{ __('correct_answer') }}</strong> (Required, Value: True or False)</td>
                                                        <td> {{ __('correct_answer') }}</td>
                                                    </tr>
                                                        <td>4</td>
                                                        <td><strong>{{ __('image') }}</strong></td>
                                                        <td> {{ __('image') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td><strong>{{ __('audio') }}</strong></td>
                                                        <td> {{ __('audio') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td><strong>{{ __('video') }}</strong></td>
                                                        <td> {{ __('video') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td><strong> {{ __('mark') }}</strong>(Required)</td>
                                                        <td> {{ __('mark') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>8</td>
                                                        <td><strong> {{ __('ques_type') }}</strong>(Required, Determine question type! Choose any one : 'multiple_choice','true_false','fill_blank','match_following' )</td>
                                                        <td> {{ __('ques_type') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>9</td>
                                                        <td><strong> {{ __('quiz_id') }}</strong> (Required, default value:{{$quiz->id}})</td>
                                                        <td> {{ __('quiz_id') }}</td>
                                                    </tr>
                                                    <tr>
                                                </tbody>
                                            </table>
                                            {{-- --------- Table end-------------------------- --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-pills-match_following" role="tabpanel"
                            aria-labelledby="v-pills-fill_blanks-tab" tabindex="3">
                            <div class="client-detail-block mb-4">
                                <div class="row">
                                    <div class="col-lg-9 col-md-8">
                                        <h5> {{ __('Import Match The Following') }}</h5>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <button onclick="downloadMatchFollowingCSV()" class="btn btn-primary float-lg-end float-md-end float-sm-start"
                                            title=" {{ __('Download Demo CSV') }}">
                                            {{ __('Download Demo CSV') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="client-detail-block">
                                            <form action="{{route('objective.importMatchFollowing',['id' => $quiz->id])}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <h5 class="block-heading"> {{ __('Import') }}</h5>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group mb-5">
                                                            <label for="" class="form-label"> {{ __('Select CSV File :') }}</label>
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-8 col-8">
                                                                    <input class="form-control" type="file" name="file" accept=".csv" required>
                                                                    <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-4">
                                                                    <div class="user-import-submit-btn">
                                                                        <button type="submit" title=" {{ __('Submit') }}"
                                                                            class="btn btn-primary">{{ __('Submit') }}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="table-responsive">
                                                <!--  Table start-->
                                                <table class="table data-table display nowrap" id="example">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Column No') }}</th>
                                                            <th>{{ __(' Column Name') }}</th>
                                                            <th>{{ __('Description') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td><strong>{{ __('question') }}</strong> (Required)</td>
                                                            <td>{{ __('question') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td><strong>{{ __('option_a') }}</strong> (Required, Store them in form of array so differentiate values with "||") </td>
                                                            <td>{{ __('option_a') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td><strong>{{ __('option_b') }}</strong> (Required, Store them in form of array so differentiate values with "||") </td>
                                                            <td>{{ __('option_b') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td><strong>{{ __('correct_answer') }}</strong> (Required, Store them in form of array so differentiate values with "||")</td>
                                                            <td> {{ __('correct_answer') }}</td>
                                                        </tr>
                                                            <td>5</td>
                                                            <td><strong>{{ __('image') }}</strong></td>
                                                            <td> {{ __('image') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>6</td>
                                                            <td><strong>{{ __('audio') }}</strong></td>
                                                            <td> {{ __('audio') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>7</td>
                                                            <td><strong>{{ __('video') }}</strong></td>
                                                            <td> {{ __('video') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>8</td>
                                                            <td><strong> {{ __('mark') }}</strong>(Required)</td>
                                                            <td> {{ __('mark') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>9</td>
                                                            <td><strong> {{ __('ques_type') }}</strong>(Required, Determine question type! Choose any one : 'multiple_choice','true_false','fill_blank','match_following' )</td>
                                                            <td> {{ __('ques_type') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>10</td>
                                                            <td><strong> {{ __('quiz_id') }}</strong> (Required, default value:{{$quiz->id}})</td>
                                                            <td> {{ __('quiz_id') }}</td>
                                                        </tr>
                                                        <tr>
                                                    </tbody>
                                                </table>
                                                {{-- --------- Table end-------------------------- --}}
                                            </div>
                                        </div>
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

@section('scripts')
<script>
    function downloadMCQCSV() {
        const csvContent = 'question,option_a,option_b,option_c,option_d,correct_answer,image,audio,video,mark,ques_type,quiz_id';
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'objective.csv';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
<script>
    function downloadTrueFalseCSV() {
        const csvContent = 'question,option_a,option_b,correct_answer,image,auido,video,mark,ques_type,quiz_id';
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'true_false.csv';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
<script>
    function downloadFillBlankCSV() {
        const csvContent = 'question,option_a,correct_answer,image,auido,video,mark,ques_type,quiz_id';
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'fill_blank.csv';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
<script>
    function downloadMatchFollowingCSV() {
        const csvContent = 'question,option_a,option_b,correct_answer,image,auido,video,mark,ques_type,quiz_id';
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = 'match_following.csv';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
