@extends('admin.layouts.master')
@section('title', 'Quiz')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['thirdactive' => 'active'])
            @slot('heading')
                {{ __('Add Question') }}
            @endslot
            @slot('menu1')
                {{ __('Add Question') }}
            @endslot
            @slot('menu2')
                {{ __('Add') }}
            @endslot
            @slot('button')

                <div class="col-md-6 col-lg-6">
                    <div class="widget-button">
                        <a href="{{ route('objective.index',['id'=>$quiz->id]) }}" class="btn btn-primary" title="{{ __('Back') }}"><i class="flaticon-back"></i>{{ __('Back') }}</a>
                    </div>
                </div>
            @endslot
        @endcomponent

        <!-- Start Contentbar -->
        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12">

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
                    </div>
                <!-- End Tab-button Code -->

                <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-mcq" role="tabpanel" aria-labelledby="v-pills-mcq-tab" tabindex="0">

                            <!-- MCQ Form code start -->
                            <form id="multipleChoiceForm" action="{{ route('objective.edit_post' , ['id'=>$quiz->id ,'obj_id' => $obj->id])}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="ques_type" value="multiple_choice">
                                <div class="client-detail-block">
                                    <h5 class="block-heading">{{ __('Add Question') }}</h5>
                                    <div class="row">
                                        <div class="col-lg-9 col-md-6 ">
                                            <div class="form-group">
                                                <label for="question" class="form-label">{{ __('Question') }}<span class="required">*</span></label>
                                                <input class="form-control" type="text" name="question" id="question" placeholder="{{ __('Please enter your question ') }}" aria-label="question" value="{{ isset($obj->question) ? $obj->question : '' }}" >
                                                <div class="form-control-icon"><i class="flaticon-question-2"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="mark" class="form-label">{{ __('Question Mark') }}<span class="required">*</span></label>
                                                <input class="form-control" type="number" name="mark" id="mark" placeholder="{{ __('Please enter mark') }}" aria-label="mark" value="{{ isset($obj->mark) ? $obj->mark : '' }}" >
                                                <div class="form-control-icon"><i class="flaticon-alert"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-3">
                                            <div class="form-group">
                                                <label for="option_a" class="form-label">{{ __('Option A') }}<span class="required">*</span></label>
                                                <input class="form-control" type="text" name="option_a" id="option_a" placeholder="{{ __('Please enter Option A') }}" aria-label="option_a" value="{{ isset($obj->option_a) ? implode(' || ', $obj->option_a) : '' }}">
                                                <div class="form-control-icon"><i class="flaticon-a"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-3">
                                            <div class="form-group">
                                                <label for="option_b" class="form-label">{{ __('Option B') }}<span class="required">*</span></label>
                                                <input class="form-control" type="text" name="option_b" id="option_b" placeholder="{{ __('Please enter Option B') }}" aria-label="option_b" value="{{ isset($obj->option_b) ? implode(' || ', $obj->option_b) : '' }}">
                                                <div class="form-control-icon"><i class="flaticon-b"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-3">
                                            <div class="form-group">
                                                <label for="option_c" class="form-label">{{ __('Option C') }}<span class="required">*</span></label>
                                                <input class="form-control" type="text" name="option_c" id="option_c" placeholder="{{ __('Please enter Option C') }}" aria-label="option_c" value="{{ isset($obj->option_c) ? $obj->option_c : '' }}">
                                                <div class="form-control-icon"><i class="flaticon-c"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-3">
                                            <div class="form-group">
                                                <label for="option_d" class="form-label">{{ __('Option D') }}<span class="required">*</span></label>
                                                <input class="form-control" type="text" name="option_d" id="option_d" placeholder="{{ __('Please enter Option D') }}" aria-label="option_d" value="{{ isset($obj->option_d) ? $obj->option_d : '' }}">
                                                <div class="form-control-icon"><i class="flaticon-d"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="correct_answer" class="form-label">{{ __('Correct Answer') }}<span class="required">*</span></label>
                                                <select class="form-control" name="correct_answer" id="correct_answer" aria-label="correct_answer">
                                                    <option value="" disabled selected>{{__('Please Select Option')}}</option>
                                                    <option value="Option A" {{ $obj->correct_answer == 'Option A' ? 'selected' : '' }}>{{__('Option A')}}</option>
                                                    <option value="Option B" {{ $obj->correct_answer == 'Option B' ? 'selected' : '' }}>{{__('Option B')}}</option>
                                                    <option value="Option C" {{ $obj->correct_answer == 'Option C' ? 'selected' : '' }}>{{__('Option C')}}</option>
                                                    <option value="Option D" {{ $obj->correct_answer == 'Option D' ? 'selected' : '' }}>{{__('Option D')}}</option>
                                                </select>
                                                <div class="form-control-icon"><i class="flaticon-check-mark"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-8 col-8">
                                                        <label for="image" class="form-label">{{ __('Image') }}</label>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-4">
                                                        <div class="suggestion-icon float-end">
                                                            <div class="tooltip-icon">
                                                                <div class="tooltip">
                                                                    <div class="credit-block">
                                                                        <small class="recommended-font-size">{{ __('Recommended Size
                                                                            : 720x900') }}</small>
                                                                    </div>
                                                                </div>
                                                                <span class="float-end"><i class="flaticon-info"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input class="form-control" type="file" name="image" id="image" accept="image/*">
                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="audio" class="form-label">{{ __('Audio Link') }}</label>
                                                <input class="form-control" type="url" name="audio" id="audio" placeholder="{{ __('Your video link here') }}"  value="{{ isset($obj->audio ) ? $obj->audio  : '' }}" aria-label="link">
                                                <div class="form-control-icon"><i class="flaticon-volume"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="video" class="form-label">{{ __('Video Link') }}</label>
                                                <input class="form-control" type="url" name="video" id="video" placeholder="{{ __('Your video  link here') }}"  value="{{ isset($obj->video ) ? $obj->video  : '' }}" aria-label="link">
                                                <div class="form-control-icon"><i class="flaticon-video"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <input type="hidden" name="subject" value="{{ isset($quiz->id ) ? $quiz->id  : '' }}">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" title="{{ __('Update') }}">{{ __('Update') }}</button>
                                </div>
                            </form>
                            <!-- MCQ Form code end -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-true_false" role="tabpanel" aria-labelledby="v-pills-true_false-tab" tabindex="1">
                            <!-- True False Form code start -->
                            <form id="trueFalseForm" action="{{ route('objective.edit_post' ,['id'=>$quiz->id,'obj_id' => $obj->id])}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="ques_type" value="true_false">
                                <div class="client-detail-block">
                                    <h5 class="block-heading">{{ __('Add Question') }}</h5>
                                    <div class="row">
                                        <div class="col-lg-9 col-md-6 ">
                                            <div class="form-group">
                                                <label for="questiontrue" class="form-label">{{ __('Question') }}<span class="required">*</span></label>
                                                <input class="form-control" type="text" name="question" id="questiontrue" placeholder="{{ __('Please enter your question') }}" aria-label="question" value="{{ isset($obj->question) ? $obj->question : '' }}">
                                                <div class="form-control-icon"><i class="flaticon-question-2"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="mark" class="form-label">{{ __('Question Mark') }}<span class="required">*</span></label>
                                                <input class="form-control" type="number" name="mark" id="mark" placeholder="{{ __('Please enter mark') }}" aria-label="mark" value="{{ isset($obj->mark) ? $obj->mark : '' }}">
                                                <div class="form-control-icon"><i class="flaticon-alert"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="option_a" class="form-label">{{ __('Option 1') }}<span class="required">*</span></label>
                                                <select class="form-control" name="option_a" id="option_a" aria-label="option_a">
                                                    <option value="True" {{ $obj->option_a == 'True' ? 'selected' : '' }}>{{__('True')}}</option>
                                                </select>
                                                <div class="form-control-icon"><i class="flaticon-check-3"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="option_b" class="form-label">{{ __('Option 2') }}<span class="required">*</span></label>
                                                <select class="form-control" name="option_b" id="option_b" aria-label="option_b">
                                                    <option value="False" {{ $obj->option_b == 'False' ? 'selected' : '' }}>{{__('False')}}</option>
                                                </select>
                                                <div class="form-control-icon"><i class="flaticon-wrong"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="correct_answer" class="form-label">{{ __('Correct Answer') }}<span class="required">*</span></label>
                                                <select class="form-control" name="correct_answer" id="correct_answer" aria-label="correct_answer">
                                                    <option value="" disabled selected>{{__('Please Select Option')}}</option>
                                                    <option value="True" {{ $obj->correct_answer == 'True' ? 'selected' : '' }}>{{__('True')}}</option>
                                                    <option value="False" {{ $obj->correct_answer == 'False' ? 'selected' : '' }}>{{__('False')}}</option>
                                                </select>
                                                <div class="form-control-icon"><i class="flaticon-check-mark"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-8 col-8">
                                                        <label for="image" class="form-label">{{ __('Image') }}</label>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-4">
                                                        <div class="suggestion-icon float-end">
                                                            <div class="tooltip-icon">
                                                                <div class="tooltip">
                                                                    <div class="credit-block">
                                                                        <small class="recommended-font-size">{{ __('Recommended Size
                                                                            : 720x900') }}</small>
                                                                    </div>
                                                                </div>
                                                                <span class="float-end"><i class="flaticon-info"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input class="form-control" type="file" name="image" id="image" accept="image/*">
                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-3">
                                            <div class="form-group">
                                                <label for="audio" class="form-label">{{ __('Audio Link') }}</label>
                                                <input class="form-control" type="url" name="audio" id="audio" placeholder="{{ __('Your audio link here') }}" aria-label="link" value="{{ isset($obj->audio) ? $obj->audio : '' }}" >
                                                <div class="form-control-icon"><i class="flaticon-volume"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-3">
                                            <div class="form-group">
                                                <label for="video" class="form-label">{{ __('Video Link') }}</label>
                                                <input class="form-control" type="url" name="video" id="video" placeholder="{{ __('Your video link here') }}" aria-label="link" value="{{ isset($obj->video) ? $obj->video : '' }}">
                                                <div class="form-control-icon"><i class="flaticon-video"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <input type="hidden" name="subject" value="{{ isset($quiz->id ) ? $quiz->id  : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" title="{{ __('Update') }}">{{ __('Update') }}</button>
                                </div>
                            </form>
                            <!-- True False Form code end -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-fill_blanks" role="tabpanel" aria-labelledby="v-pills-fill_blanks-tab" tabindex="2">
                            <!-- Fill In the Blanks Form code start -->
                            <form id="fill_blank" action="{{ route('objective.edit_post' , ['id'=>$quiz->id ,'obj_id' => $obj->id])}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="ques_type" value="fill_blank">
                                <div class="client-detail-block">
                                    <h5 class="block-heading">{{ __('Add Question') }}</h5>
                                    <div class="row">
                                        <div class="col-lg-9 col-md-6 ">
                                            <div class="form-group">
                                                <label for="questionfillup" class="form-label">{{ __('Question') }}<span class="required">*</span></label>
                                                <input class="form-control fill_question" type="text" name="question" id="questionfillup" placeholder="{{ __('Please enter your question ') }}" value="{{ isset($obj->question) ? $obj->question : '' }}" aria-label="question">
                                                <div class="form-control-icon"><i class="flaticon-question-2"></i></div>
                                            </div>
                                            <button id="addBlankLineBtn" type="button" class="btn btn-primary mb-3">{{__('Add Blank line')}}</button>
                                            <button id="removeBlankLineBtn" type="button" class="btn btn-danger mb-3">{{__('Remove Blank line')}}</button>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="mark" class="form-label">{{ __('Question Mark') }}<span class="required">*</span></label>
                                                <input class="form-control" type="number" name="mark" id="mark" placeholder="{{ __('Please enter mark') }}" aria-label="mark" value="{{isset($obj->mark) ? $obj->mark : '' }}">
                                                <div class="form-control-icon"><i class="flaticon-alert"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="correct_answer" class="form-label">{{ __('Correct Answer') }}<span class="required">*</span></label>
                                                <input class="form-control" type="text" name="correct_answer" id="correct_answer" placeholder="{{ __('Please enter your question ') }}" aria-label="correct_answer" value="{{ isset($obj->correct_answer) ? implode(' || ', $obj->correct_answer) : '' }}""  ><div class="form-control-icon"><i class="flaticon-check-mark"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-8 col-8">
                                                        <label for="image" class="form-label">{{ __('Image') }}</label>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-4">
                                                        <div class="suggestion-icon float-end">
                                                            <div class="tooltip-icon">
                                                                <div class="tooltip">
                                                                    <div class="credit-block">
                                                                        <small class="recommended-font-size">{{ __('Recommended Size
                                                                            : 720x900') }}</small>
                                                                    </div>
                                                                </div>
                                                                <span class="float-end"><i class="flaticon-info"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input class="form-control" type="file" name="image" id="image" accept="image/*">
                                                <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="audio" class="form-label">{{ __('Audio Link') }}</label>
                                                <input class="form-control" type="url" name="audio" id="audio" placeholder="{{ __('Your audio link here') }}" aria-label="link" value="{{ isset($obj->audio) ? $obj->audio : '' }}">
                                                <div class="form-control-icon"><i class="flaticon-volume"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="video" class="form-label">{{ __('Video Link') }}</label>
                                                <input class="form-control" type="url" name="video" id="video" placeholder="{{ __('Your video link here') }}" aria-label="link" value="{{ isset($obj->video) ? $obj->video : '' }}">
                                                <div class="form-control-icon"><i class="flaticon-video"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <input type="hidden" name="subject" value="{{ isset($quiz->id ) ? $quiz->id  : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" title="{{ __('Update') }}">{{ __('Update') }}</button>
                                </div>
                            </form>
                            <!-- Fill In The Blanks Form code end -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-match_following" role="tabpanel" aria-labelledby="v-pills-fill_blanks-tab" tabindex="3">
                            <!-- Match The Following Form code start -->
                            <form id="matchFollowing" action="{{ route('objective.create_post',['id' => $quiz->id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="ques_type" value="match_following">
                                <div class="client-detail-block">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <label for="questionmatch" class="form-label">{{ __('Question') }}<span class="required">*</span></label>
                                                <input class="form-control fill_question" type="text" name="question" id="questionmatch" placeholder="{{ __('Please enter your question ') }}" aria-label="question" value="{{ $obj->question }}">
                                                <div class="form-control-icon"><i class="flaticon-question-2"></i></div>
                                            </div>
                                            <div class="row" id="options-container">
                                                @foreach ($obj->option_a as $index => $optionA)
                                                    <div class="col-lg-6">
                                                        <h5 class="matche-heading">{{ __('Column A') }}</h5>
                                                        <div class="form-group">
                                                            <label class="form-label">{{ chr(65 + $index) }}<span class="required">*</span></label>
                                                            <input class="form-control" type="text" name="option_a[]" placeholder="{{ __('Please enter your text') }}" aria-label="option_a" value="{{ $optionA }}">
                                                            <div class="form-control-icon"><i class="flaticon-process"></i></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h5 class="matche-heading">{{ __('Column B') }}</h5>
                                                        <div class="form-group">
                                                            <label class="form-label">{{ $index + 1 }}<span class="required">*</span></label>
                                                            <input class="form-control" type="text" name="option_b[]" placeholder="{{ __('Please enter your text') }}" aria-label="option_b" value="{{ $obj->option_b[$index] }}">
                                                            <div class="form-control-icon"><i class="flaticon-process"></i></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-secondary mb-3" id="add-options">{{ __('Add More') }}</button>
                                            <button type="button" class="btn btn-danger mb-3" id="remove-options">{{ __('Remove Last') }}</button>
                                            <div class="col-lg-12">
                                                <h5 class="matche-heading" id="correctAnswer">{{ __('Correct Answer') }}</h5>
                                                <div class="row" id="correct-options-container">
                                                    @foreach ($obj->correct_answer as $index => $correctAnswer)
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="correct_answer_left" class="form-label">{{ __('Correct Sequence') }}</label>
                                                                <input class="form-control" type="text" name="correct_answer_left[]" value="{{ chr(65 + $index) }}" disabled>
                                                                <div class="form-control-icon">
                                                                    <i class="flaticon-process"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="correct_answer_right" class="form-label">{{ __('Enter your sequence') }}</label>
                                                                <input class="form-control" type="number" name="correct_answer[]" placeholder="{{ __('Enter your sequence') }}" aria-label="correct_answer_right" value="{{ $correctAnswer }}">
                                                                <div class="form-control-icon">
                                                                    <i class="flaticon-process"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="audio" class="form-label">{{ __('Audio Link') }}</label>
                                                        <input class="form-control" type="url" name="audio" id="audio" placeholder="{{ __('Your video link here') }}" aria-label="link" value="{{ isset($obj->audio) ? $obj->audio : '' }}">
                                                        <div class="form-control-icon"><i class="flaticon-volume"></i></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="video" class="form-label">{{ __('Video Link') }}</label>
                                                        <input class="form-control" type="url" name="video" id="video" placeholder="{{ __('Your video link here') }}" aria-label="link" value="{{ isset($obj->video) ? $obj->video : '' }}">
                                                        <div class="form-control-icon"><i class="flaticon-video"></i></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-8 col-md-8 col-8">
                                                                <label for="image" class="form-label">{{ __('Image') }}</label>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-4">
                                                                <div class="suggestion-icon float-end">
                                                                    <div class="tooltip-icon">
                                                                        <div class="tooltip">
                                                                            <div class="credit-block">
                                                                                <small class="recommended-font-size">{{ __('Recommended Size
                                                                                    : 720x900') }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input class="form-control" type="file" name="image" id="image" accept="image/*">
                                                        <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="mark" class="form-label">{{ __('Question Mark') }}<span class="required">*</span></label>
                                                        <input class="form-control" type="number" name="mark" id="mark" placeholder="{{ __('Please enter mark') }}" aria-label="mark" value="{{ isset($obj->mark) ? $obj->mark : '' }}">
                                                        <div class="form-control-icon"><i class="flaticon-alert"></i></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="hidden" name="subject" value="{{ isset($quiz->id ) ? $quiz->id  : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" title="{{ __('Submit') }}">{{ __('Submit') }}</button>
                                </div>
                            </form>
                            <!-- Match The Following Form code end -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Contentbar -->
        </div>
    @endsection
