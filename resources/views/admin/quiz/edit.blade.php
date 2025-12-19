@extends('admin.layouts.master')
@section('title', 'Quiz')
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
    {{ __('Edit ') }}
    @endslot

    @slot('button')
    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('quiz.index') }}" title="{{__('Back')}} class="btn btn-primary"><i class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent

    <!-- Start Contentbar -->
    <div class="contentbar profile-main-block">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!-- Form  Code start-->
                <form action="{{ route('quiz.edit_post', ['id' => $quiz->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="client-detail-block">
                        <h5 class="block-heading">{{ __('Edit Quiz Details ') }}</h5>
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 ">
                                        <div class="form-group">
                                            <label for="quizName" class="form-label">{{ __('Quiz Name') }}<span class="required">*</span></label>
                                            <input class="form-control" type="text" name="name" id="quizName" placeholder="{{ __('Enter Name of your Quiz') }}" aria-label="Quiz Name" value="{{ isset($quiz->name) ? $quiz->name : '' }}">
                                            <div class="form-control-icon"><i class="flaticon-speech-bubble-1"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
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
                                                                    <small class="recommended-font-size">{{ __('Recommended Size: 720x900') }}</small>
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
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="subject" class="form-label">{{ __('Subject Name') }}<span class="required">*</span></label>
                                            <input class="form-control" type="text" name="subject" id="subject" placeholder="{{ __('Enter Name of subject') }}" aria-label="Quiz Subject" value="{{ isset($quiz->subject) ? $quiz->subject : '' }}">
                                            <div class="form-control-icon"><i class="flaticon-books"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group">
                                            <label for="timer" class="form-label">{{ __('Timer (in minutes)') }}<span class="required">*</span></label>
                                            <input class="form-control" type="text" name="timer" id="timer" placeholder="{{ __('Enter Time') }}" aria-label="Timer" value="{{ isset($quiz->timer) ? $quiz->timer : '' }}">
                                            <div class="form-control-icon"><i class="flaticon-stopwatch"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3">
                                        <div class="form-group">
                                            <label for="start_date" class="form-label">{{ __('Starting Date') }}<span class="required">*</span></label>
                                            <input class="form-control" type="date" name="start_date" id="start_date" placeholder="{{ __('Please enter Starting Date of Quiz') }}" aria-label="start_date" value="{{$quiz->start_date}}">
                                            <div class="form-control-icon"><i class="flaticon-calendar-1"></i></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3">
                                        <div class="form-group">
                                            <label for="end_date" class="form-label">{{ __('Ending Date') }}<span class="required">*</span></label>
                                            <input class="form-control" type="date" name="end_date" id="end_date" placeholder="{{ __('Please enter Ending Date of Quiz') }}" aria-label="end_date" value="{{ isset($quiz->end_date) ? $quiz->end_date : '' }}">
                                            <div class="form-control-icon"><i class="flaticon-calendar-1"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3">
                                        <div class="form-group">
                                            <label for="category" class="form-label">{{ __('Category') }}<span class="required">*</span></label>
                                            <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="category" required>
                                                <option value="" disabled {{ old('category_id', $quiz->category_id) ? '' : 'selected' }}>{{ __('Please Select Option') }}</option>
                                                @foreach ($category as $data)
                                                    <option value="{{ $data->id }}" {{ old('category_id', $quiz->category_id) == $data->id ? 'selected' : '' }}>
                                                        {{ $data->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="form-control-icon"><i class="flaticon-check-mark"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="desc" class="form-label">{!! __('Description') !!}</label>
                                            <textarea class="form-control" id="desc" name="desc" rows="2" placeholder="{!! __('Enter Description') !!}">{{ isset($quiz->description) ? $quiz->description : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('Select Quiz Type') }}</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type" id="typeSubjective" value="0" {{ isset($quiz->type) && $quiz->type == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="typeSubjective">
                                                    {{ __('Subjective') }}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type" id="typeObjective" value="1" {{ isset($quiz->type) && $quiz->type == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="typeObjective">
                                                    {{ __('Objective') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-8">
                                                <div class="form-group">
                                                    <label for="reattempt" class="form-label">{{ __('Reattempt') }}</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="reattempt" name="reattempt" value="1" {{ isset($quiz->reattempt) && $quiz->reattempt == 1 ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-4">
                                                <div class="suggestion-icon float-end">
                                                    <div class="tooltip-icon">
                                                        <div class="tooltip">
                                                            <div class="credit-block">
                                                                <small class="recommended-font-size">{{ __('Can students retake quiz to improve their scores?') }}</small>
                                                            </div>
                                                        </div>
                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-3">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-8">
                                                <div class="form-group">
                                                    <label for="question_order" class="form-label">{{ __('Order') }}</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="question_order" id="question_order" name="question_order" value="1" {{ isset($quiz->question_order) && $quiz->question_order == 1 ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-4">
                                                <div class="suggestion-icon float-end">
                                                    <div class="tooltip-icon">
                                                        <div class="tooltip">
                                                            <div class="credit-block">
                                                                <small class="recommended-font-size">{{ __('Question genrate randomly or by sequence') }}</small>
                                                            </div>
                                                        </div>
                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-3">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-8">
                                                <div class="form-group">
                                                    <label for="service" class="form-label">{{ __('Paid') }}</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input service-quiz" type="checkbox" role="switch" id="service" name="service" value="1" {{ isset($quiz->service) && $quiz->service == 1 ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-4">
                                                <div class="suggestion-icon float-end">
                                                    <div class="tooltip-icon">
                                                        <div class="tooltip">
                                                            <div class="credit-block">
                                                                <small class="recommended-font-size">{{ __('Quiz is paid or free?') }}</small>
                                                            </div>
                                                        </div>
                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-3" id="service-fees">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-8 col-8">
                                                <div class="form-group">
                                                    <label for="fees" class="form-label">{{ __('fees') }}</label>
                                                    <input class="form-control @error('fees') is-invalid @enderror" type="number" name="fees" id="fees" placeholder="{{ __('Enter fees') }}" aria-label="Quiz Fees"  value="{{ isset($quiz->fees) ? $quiz->fees : '' }}">
                                                    <div class="form-control-icon"><i class="flaticon-books"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                    $endDate = \Carbon\Carbon::parse($quiz->end_date ?? now())->format('Y-m-d\TH:i');
                                    @endphp
                                <br> 
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        role="switch" 
                                        id="status" 
                                        name="status" 
                                        value="1"
                                        {{ isset($quiz->status) && $quiz->status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">Status</label>
                                </div>
                                <small id="status-msg" class="text-danger" style="display: none;">
                                    This quiz has expired. You cannot change the status.
                                </small>
                                <script>
                                    function checkEndDateAndToggleStatus() {
                                        const endDateInput = document.getElementById('end_date');
                                        const statusToggle = document.getElementById('status');
                                        const msg = document.getElementById('status-msg');
                                        const endDate = new Date(endDateInput.value);
                                        const now = new Date();
                                        if (endDate < now) {
                                            statusToggle.disabled = true;
                                            msg.style.display = 'inline';
                                        } else {
                                            statusToggle.disabled = false;
                                            msg.style.display = 'none';
                                        }
                                    }
                                
                                    // Check on page load
                                    document.addEventListener('DOMContentLoaded', checkEndDateAndToggleStatus);
                                
                                    // Also check whenever end_date input changes
                                    document.getElementById('end_date').addEventListener('change', checkEndDateAndToggleStatus);
                                </script>                                 
                                </div>
                            </div>
                        </div>
                    </div>
                <button type="submit" class="btn btn-primary" title="{{ __('Update') }}">{{ __('Update') }}</button>
                </form>
                <!-- Form  Code end-->
            </div>
        </div>
    </div>
    <!-- End Contentbar -->
@endsection
@section('scripts')

<script>
    CKEDITOR.replace('desc');
</script>
@endsection
