@extends('admin.layouts.master')
@section('title', 'Quiz')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Quiz ') }}
    @endslot
    @slot('menu1')
    {{ __('Quiz') }}
    @endslot
    @slot('menu2')
    {{ __('Add') }}
    @endslot
    @slot('button')

    <div class="col-md-7 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('quiz.index') }}" class="btn btn-primary" title="{{ __('Back') }}"><i class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <!-- Start Contentbar -->
    <div class="contentbar  ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!-- form code start -->
                <form action="{{route('quiz.create_post')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <h5 class="block-heading">{{__('Add Quiz')}}</h5>
                        <div class="row">
                            <div class="col-lg-10 col-md-8">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label for="quizName" class="form-label">{{ __('Quiz Name') }}<span class="required">*</span></label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="quizName" placeholder="{{ __('Enter Name of your Quiz') }}" aria-label="Quiz Name" value="{{ old('name') }}">
                                            <div class="form-control-icon"><i class="flaticon-speech-bubble-1"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
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
                                    <div class="col-lg-3 col-md-6">
                                        <div class="form-group">
                                            <label for="subject" class="form-label">{{ __('Subject Name') }}<span class="required">*</span></label>
                                            <input class="form-control @error('subject') is-invalid @enderror" type="text" name="subject" id="subject" placeholder="{{ __('Enter subject Name') }}" aria-label="Quiz Subject" value="{{ old('subject') }}">
                                            <div class="form-control-icon"><i class="flaticon-books"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group">
                                            <label for="timer" class="form-label">{{ __('Timer (in minutes)') }}<span class="required">*</span></label>
                                            <input class="form-control @error('timer') is-invalid @enderror" type="number" name="timer" id="timer" placeholder="{{ __('Timer') }}" aria-label="Timer" value="{{ old('timer') }}">
                                            <div class="form-control-icon"><i class="flaticon-stopwatch"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3">
                                        <div class="form-group">
                                            <label for="start_date" class="form-label">{{ __('Starting Date') }}<span class="required">*</span></label>
                                            <input class="form-control @error('start_date') is-invalid @enderror" type="date" name="start_date" id="start_date" placeholder="{{ __('Please enter Starting Date of Quiz') }}" aria-label="start_date" value="{{ old('start_date') }}">
                                            <div class="form-control-icon"><i class="flaticon-calendar-1"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3">
                                        <div class="form-group">
                                            <label for="end_date" class="form-label">{{ __('Ending Date') }}<span class="required">*</span></label>
                                            <input class="form-control @error('end_date') is-invalid @enderror" type="date" name="end_date" id="end_date" placeholder="{{ __('Please enter ending Date of Quiz') }}" aria-label="end_date" value="{{ old('end_date') }}">
                                            <div class="form-control-icon"><i class="flaticon-calendar-1"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3">
                                        <div class="form-group">
                                            <label for="category" class="form-label">{{ __('Category') }}<span class="required">*</span></label>
                                            <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="category" required>
                                                <option value="" disabled selected>{{ __('Please Select Option') }}</option>
                                                @foreach ($category as $data)
                                                    <option value="{{ $data->id }}" {{ old('category_id') == $data->id ? 'selected' : '' }}>
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
                                            <textarea class="form-control" id="desc" name="desc" placeholder="{!! __('Enter Description') !!}"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ __('Select Quiz Type') }}</label>
                                            <div class="form-check">
                                                <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type" id="typeSubjective" value="0" {{ old('type') == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="typeSubjective">
                                                    {{ __('Subjective') }}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type" id="typeObjective" value="1" {{ old('type') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="typeObjective">
                                                    {{ __('Objective') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-3">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-8">
                                                <div class="form-group">
                                                    <label for="reattempt" class="form-label">{{ __('Reattempt') }}</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input @error('reattempt') is-invalid @enderror" type="checkbox" role="switch" id="reattempt" name="reattempt" value="1" {{ old('reattempt') ? 'checked' : '' }}>
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
                                                    <div class="form-check form-switch @error('question_order') is-invalid @enderror">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="question_order" name="question_order" value="1" {{ old('question_order') ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-4">
                                                <div class="suggestion-icon float-end">
                                                    <div class="tooltip-icon">
                                                        <div class="tooltip">
                                                            <div class="credit-block">
                                                                <small class="recommended-font-size">{{ __('Determine Order of questions') }}</small>
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
                                                        <input class="form-check-input service-quiz @error('service') is-invalid @enderror" type="checkbox" role="switch" id="service" name="service" value="1" {{ old('service') ? 'checked' : '' }}>
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
                                                    <input class="form-control @error('fees') is-invalid @enderror" type="number" name="fees" id="fees" placeholder="{{ __('Enter fees') }}" aria-label="Quiz Fees" value="{{ old('fees') }}">
                                                    <div class="form-control-icon"><i class="flaticon-books"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-8">
                                                <div class="form-group">
                                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" role="switch" id="status" name="status" value="1" checked>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-4 col-4">
                                                <div class="suggestion-icon float-end">
                                                    <div class="tooltip-icon">
                                                        <div class="tooltip">
                                                            <div class="credit-block">
                                                                <small class="recommended-font-size">{{ __('This quiz is active or not!! ') }}</small>
                                                            </div>
                                                        </div>
                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" title="{{ __('Add') }}" class="btn btn-primary mt-3" name="action" value="add">
                        <i class="flaticon-upload-1"></i>
                        {{ __('Add') }}
                    </button>
                    <button type="submit" title="{{ __('Save & Add') }}" class="btn btn-primary mt-3" name="action" value="add_new">
                        <i class="flaticon-upload-1"></i>
                        {{ __('Save & Add') }}
                    </button>
                </form>
            </div>
            <!-- form code end -->
        </div>
    </div>
    <!-- End Contentbar -->
</div>


@endsection
