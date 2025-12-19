@extends('admin.layouts.master')
@section('title', 'Team Member Create')
@section('main-container')
<div class="dashboard-card">
    @component('admin.components.breadcumb', ['thirdactive' => 'active'])
        @slot('heading')
            {{ __('Team Member Create') }}
        @endslot
        @slot('menu1')
            {{ __('Team Member') }}
        @endslot
        @slot('menu2')
            {{ __('Team Member Create') }}
        @endslot
        @slot('button')
            <div class="col-md-6 col-lg-6">
                <div class="widget-button">
                    <a href="{{ route('members.show') }}" class="btn btn-primary"><i class="flaticon-back"
                            title="{{ __('Back') }}"></i>
                        {{ __('Back') }}</a>
                </div>
            </div>
        @endslot
    @endcomponent

    <div class="contentbar profile-main-block">
        @include('admin.layouts.flash_msg');
        <div class="row">
            <div class="col-lg-12">
                <!--form code start-->
                <form action="{{ route('members.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="name" class="form-label">{{ __('Team Member Name') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                        name="name" id="name" placeholder="{{ __('Please Enter Your Name') }}"
                                        aria-label="Name" value="{{ old('name') }}" required>
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
                                        aria-label="Designation" value="{{ old('designation') }}" required>
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
                                            <p>Drag & Drop to Upload Files</p>
                                            <p>OR</p>
                                            <div class="button-container">
                                                <label for="image" class="btn btn-primary">
                                                    <i class="flaticon-upload"></i> Browse Files
                                                </label>
                                                <button type="button" id="capture-button" class="btn btn-secondary">
                                                    <i class="flaticon-camera"></i> Capture Image
                                                </button>
                                            </div>
                                            <input type="file" id="image" name="image" accept="image/*" class="hidden-input">
                                        </div>
                                    </div>
                                    <div class="image-preview-container mt-3">
                                        <div id="image-grid"></div>
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="desc" class="form-label">{{ __('Please enter your Bio') }}</label>
                                    <textarea class="form-control form-control-padding_15" name="bio" rows="2" id="desc"
                                        placeholder="{{ __('Please Enter Your Details') }}"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                                            name="status" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" title="{{ __('Create') }}" class="btn btn-primary">
                        <i class="flaticon-upload-1"></i> {{ __('Create') }}</button>
                    <button type="submit" name="create_and_new" value="1" class="btn btn-success">
                        <i class="flaticon-upload-1"></i> {{ __('Create & New') }}
                    </button>
                </form>
                    <!--form code end-->
            </div>
        </div>
    </div>
</div>

<div id="cameraModal" class="modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Capture Image</h5>
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
                            <button id="snap" class="btn btn-primary">Take Photo</button>
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
<script src="{{ asset('admin_theme/assets/js/team-member-create.js') }}"></script>
@endsection
