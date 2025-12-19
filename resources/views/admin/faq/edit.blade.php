@extends('admin.layouts.master')
@section('title', 'FAQ Edit')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('FAQ') }}
    @endslot
    @slot('menu1')
    {{ __('Front Panel') }}
    @endslot
    @slot('menu2')
    {{ __('FAQ') }}
    @endslot
    @slot('menu3')
    {{ __('Edit') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('faq.show') }}" title="{{ __('Back') }}" class="btn btn-primary"><i
                    class="flaticon-back"></i>{{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent
    <!-- Start Contentbar -->
    <div class="contentbar  ">
        @include('admin.layouts.flash_msg');
        <div class="client-detail-block">
            <div class="registration-block">
                <!-- Form  Code start -->
                <form action="{{ url('admin/faq/' . $faq->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="client_name" class="form-label">{{ __('Question') }}<span
                                        class="required">*</span></label>
                                <input class="form-control" type="text" name="question" id="client_name"
                                    placeholder="{{ __('Enter Question') }}" aria-label="Heading" required
                                    value="{{ $faq->question }}">
                                <div class="form-control-icon"><i class="flaticon-question-and-answer"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="desc" class="form-label">{{ __('Answer') }}<span
                                        class="required">*</span></label>
                                <textarea class="form-control form-control-padding_15" name="answer" id="desc" rows="1" required
                                    placeholder="{{ __('Please Enter Your Answer') }}">{{ $faq->answer }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="statusToggle"
                                        name="status" value="1" {{ $faq->status == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" title="{{ __('Update') }}"> {{ __('Update')
                        }}</button>
                </form>
                <!-- Form  Code end -->
            </div>
        </div>
    </div>
</div>
@endsection
