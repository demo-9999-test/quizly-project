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
                        <a href="{{ route('subjective.index',['id'=>$quiz->id]) }}" class="btn btn-primary" title="{{ __('Back') }}"><i class="flaticon-back"></i>
                            {{ __('Back') }}</a>
                    </div>
                </div>
            @endslot
        @endcomponent
        <!-- Start Contentbar -->
        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form code start -->

                    <form id="multipleChoiceForm" action="{{ route('subjective.create_post',['id' => $quiz->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="client-detail-block">
                            <h5 class="block-heading">{{ __('Add Question') }}</h5>
                            <div class="row">
                                <div class="col-lg-9 col-md-6 ">
                                    <div class="form-group">
                                        <label for="question" class="form-label">{{ __('Question') }}<span class="required">*</span></label>
                                        <input class="form-control @error('question') is-invalid @enderror" type="text" name="question" id="question" placeholder="{{ __('Please enter your question  ') }}" aria-label="question" value="{{old('question')}}">
                                        <div class="form-control-icon"><i class="flaticon-question-2"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label for="mark" class="form-label">{{ __('Question Mark') }}<span class="required">*</span></label>
                                        <input class="form-control @error('mark') is-invalid @enderror" type="number" name="mark" id="mark" placeholder="{{ __('Please enter mark') }}" aria-label="mark" value="{{old('mark')}}">
                                        <div class="form-control-icon"><i class="flaticon-alert"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3">
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
                                        <input class="form-control @error('audio') is-invalid @enderror" type="url" name="audio" id="audio" placeholder="{{ __('Please paste your video link here') }}" aria-label="link" value="{{old('audio')}}">
                                        <div class="form-control-icon"><i class="flaticon-volume"></i></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-3">
                                    <div class="form-group">
                                        <label for="video" class="form-label">{{ __('Video Link') }}</label>
                                        <input class="form-control @error('video') is-invalid @enderror" type="url" name="video" id="video" placeholder="{{ __('Please paste your audio  link here') }}" aria-label="link" value="{{old('video')}}">
                                        <div class="form-control-icon"><i class="flaticon-video"></i></div>
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
                        </div>
                    </form>
                    <!-- Form code end -->
                </div>

            </div>
        </div>
        <!-- End Contentbar -->
    </div>
@endsection
