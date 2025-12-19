@extends('admin.layouts.master')
@section('title', 'Edit Team Member')
@section('main-container')
    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['thirdactive' => 'active'])
            @slot('heading')
                {{ __('Edit Team Member') }}
            @endslot
            @slot('menu1')
                {{ __('Team Member') }}
            @endslot
            @slot('menu2')
                {{ __('Edit Team Member') }}
            @endslot
            @slot('button')
                <div class="col-md-6 col-lg-6">
                    <div class="widget-button">
                        <a href="{{ route('members.show') }}" class="btn btn-primary" title="{{ __('Back') }}"><i class="flaticon-back"></i>
                            {{ __('Back') }}</a>
                    </div>
                </div>
            @endslot
        @endcomponent

        <div class="contentbar profile-main-block">
        @include('admin.layouts.flash_msg');

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('members.update', $team->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="client-detail-block">
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="form-label">{{ __('Team Member Name') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                                            name="name" id="name" placeholder="{{ __('Please Enter Your Name') }}"
                                            aria-label="Name" value="{{ old('name', $team->name) }}" required>
                                        <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label for="designation" class="form-label">{{ __('Designation') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control @error('designation') is-invalid @enderror" type="text"
                                            name="designation" id="designation" placeholder="{{ __('Please Enter Your Designation') }}"
                                            aria-label="designation" value="{{ old('designation', $team->designation) }}" required>
                                        <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                        @error('designation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="image" class="form-label">{{ __('Image') }}<span class="required">*</span></label>
                                        <div class="image-upload-container">
                                            <div id="drop-area" class="drop-area">
                                                <p>{{__('Drag & Drop to Upload Files')}}</p>
                                                <p>{{__('OR')}}</p>
                                                <div class="button-container">
                                                    <label for="image" class="btn btn-primary">
                                                        <i class="flaticon-upload"></i> {{__('Browse Files')}}
                                                    </label>
                                                    <button type="button" id="capture-button" class="btn btn-secondary">
                                                        <i class="flaticon-camera"></i> {{__('Capture Image')}}
                                                    </button>
                                                </div>
                                                <input type="file" id="image" name="image" accept="image/*" class="hidden-input">
                                            </div>
                                        </div>
                                        <div class="image-preview-container mt-3">
                                            <div id="image-grid">
                                                @if($team->image)
                                                    <img src="{{ asset('images/team/' . $team->image) }}" alt="{{__('Team Member Image')}}" style="max-width: 100%; max-height: 300px; object-fit: contain;">
                                                @endif
                                            </div>
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="bio" class="form-label">{{ __('Bio') }}</label>
                                        <textarea class="form-control form-control-padding_15" name="bio" rows="2" id="desc"
                                            placeholder="{{ __('Please Enter Your Bio') }}">{{ old('bio', $team->bio) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                                name="status" value="1" {{ $team->status ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" title="{{ __('Update') }}" class="btn btn-primary"><i
                                class="flaticon-upload-1"></i> {{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="cameraModal" class="modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Capture Image')}}</h5>
                    <button type="button" id="closeModal" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-12">
                                <video id="video" class="img-fluid" autoplay playsinline></video>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button id="snap" class="btn btn-primary">{{__('Take Photo')}}</button>
                            </div>
                        </div>
                        <canvas id="canvas" class="d-none"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('admin_theme/assets/js/team-member-form.js') }}"></script>
@endsection
