@if(session('status') == 'error')
    <div class="alert alert-danger">
        {{ session('message') }}
    </div>
@endif

<div class="offcanvas-menu">
    <div class="row">
        <div class="col-lg-8">
            <h6 class="ai-title">
                <img src="{{url('admin_theme/assets/icons/ai.svg')}}">
                {{ __('Ai Tool')}}
            </h6>
        </div>
        <div class="col-lg-4">
            <span class="menu-close"><i class="flaticon-cancel"></i></span>
        </div>
    </div>
    <hr>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-text-tab" data-bs-toggle="pill" data-bs-target="#pills-text" type="button" role="tab" aria-controls="pills-text" aria-selected="true">Text</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-image-tab" data-bs-toggle="pill" data-bs-target="#pills-image" type="button" role="tab" aria-controls="pills-image" aria-selected="false">Image</button>
        </li>
    </ul>

    @php
        $services = App\Models\Service::where('status','1')->get();
    @endphp

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-text" role="tabpanel" aria-labelledby="pills-text-tab">
            <form id="mytext" class="openai_generator_form">
                <meta name="csrf-token" content="{{ csrf_token() }}" />
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="ai_service" class="form-label">{{ __('Service')}}</label>
                            <select name="service" class="form-select" id="service" required>
                                <option  value="" disabled selected>{{ __('Select Service') }}</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-control-icon"><i class="flaticon-heading"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="language" class="form-label">{{ __('Enter Language')}}</label>
                            <select class="form-select" id="language">
                                <option value="English">{{__('English')}}</option>
                                <option value="Arabic">{{__('Arabic')}}</option>
                                <option value="French">{{__('French')}}</option>
                                <option value="Hindi">{{__('Hindi')}}</option>
                                <option value="Spanish">{{__('Spanish')}}</option>
                            </select>
                            <div class="form-control-icon"><i class="flaticon-language"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group mb-3">
                        <label for="ai_keyword" class="form-label">{{ __('Enter your keyword')}}</label>
                        <input type="text" class="form-control" required id="keyword"  placeholder="{{ __('Enter your keyword')}}">
                    </div>
                </div>
                <div class="ai-generate-btn">
                    <button type="submit" class="btn btn-primary service_btn">{{ __('Generate')}}</button>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="generator_sidebar_table">
                            @include('admin.openai.output')
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="pills-image" role="tabpanel" aria-labelledby="pills-image-tab">
            <form id="openai_generator_form2" onsubmit="return generatorFormImage();">
                <div class="form-group mb-3">
                    <label for="ai_keyword_img" class="form-label">{{__('Enter your keyword')}}</label>
                    <input type="text" class="form-control" id="description" placeholder="Enter your keyword">
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="ai_service_img" class="form-label">{{ __('No. of Images')}}</label>
                            <select name="image_number_of_images" class="form-select" id="image_number_of_images">
                                <option value=1>{{__('1')}}</option>
                            </select>
                            <div class="form-control-icon"><i class="flaticon-gallery"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-3">
                            <label for="ai_image" class="form-label">{{ __('Enter Image Size')}}</label>
                            <select class="form-select" id="size">
                                <option value=256x256>{{__('256x256')}}</option>
                                <option value=512x512>{{__('512x512')}}</option>
                                <option value=1024x1024>{{__('1024x1024')}}</option>
                            </select>
                            <div class="form-control-icon"><i class="flaticon-header"></i></div>
                        </div>
                    </div>
                </div>
                <div class="ai-generate-btn">
                    <button id="image-generator" type="submit" class="btn btn-primary generate-btn-text">{{__('Generate')}}</button>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ai-text-result">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="image-output">
                                        @include('admin.openai.image')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="offcanvas-overly"></div>
