@extends('admin.layouts.master')
@section('title', 'Profile')
@section('main-container')

<div class="dashboard-card">
    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-main-block" aria-label="breadcrumb">
        <div class="row">
            <div class="col-lg-6">
                <div class="breadcrumbbar">
                    <h4 class="page-title">
                        @php
                            $currentHour = date('H');
                            if ($currentHour >= 5 && $currentHour < 12) {
                                $greeting = 'Good Morning';
                            } elseif ($currentHour >= 12 && $currentHour < 17) {
                                $greeting = 'Good Afternoon';
                            } elseif ($currentHour >= 17 && $currentHour < 20) {
                                $greeting = 'Good Evening';
                            } else {
                                $greeting = 'Good Night';
                            }
                        @endphp
                        {{ $greeting }}, {{ $profile->name }}.
                    </h4>
                </div>
            </div>

        </div>
    </nav>
    @component('admin.components.breadcumb',['secondaryactive' => 'active'])
        @slot('menu1')
        {{ __('Profile') }}
        @endslot
        @endcomponent
    <!-- Breadcrumb End -->
    <!-- Start Contentbar -->
    <form action="{{ url('admin/profile/' . $profile->id) }}" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="contentbar">
            <div class="profile-breadcrumb-block" aria-label="profile-breadcrumb">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-cover">
                            <img src="{{ url('admin_theme/assets/images/profile/cover.png') }}" class="img-fluid"
                                alt="{{ __('cover img') }}">
                            <div class="breadcrumb-profile">
                                @if (!empty($profile->image))
                                <img src="{{ asset('/images/users/' . $profile->image) }}" class="img-fluid" id="image"
                                    alt="{{ __('Profile') }}">
                                @else
                                <img src="{{ Avatar::create($profile->name)->toBase64() }}" class="img-fluid" id="image"
                                    alt="{{ __('Profile') }}" />
                                @endif
                                <div class="profile-section-edit">
                                    <button type="button" id="openImageModal" class="camera-button">
                                        <i class="flaticon-camera"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="profile-edit-block">
                                <i class="flaticon-editing"></i>
                                <input type="file" id="formFile" name="image" onchange="readURL(this);">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Image Selection Modal -->
<div class="modal fade" id="imageSelectionModal" tabindex="-1" aria-labelledby="imageSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageSelectionModalLabel">Update Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-primary" id="selectImageBtn">Select Image</button>
                <button type="button" class="btn btn-secondary" id="takePictureBtn">Take Picture</button>
            </div>
        </div>
    </div>
</div>
<!-- Camera Modal -->
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
<div class="profile-main-block">
<div class="row">
    <div class="col-lg-12">
        <!-- Massage Print Code start-->
        @include('admin.layouts.flash_msg')
        <!-- Massage Print Code end -->
        <div class="client-detail-block">
            <h5 class="block-heading"> {{ __('Personal Details') }}</h5>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        <label for="" class="form-label"> {{ __('Name') }}<span
                                class="required">*</span></label>
                        <input class="form-control" type="text" name="name"
                            placeholder="{{ __('Please Enter Your Name') }}" aria-label=""
                            value="{{ $profile->name }}" required>
                        <div class="form-control-icon"><i class="flaticon-user"></i></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        <label for="" class="form-label"> {{ __('Mobile No.') }}<span
                                class="required">*</span></label>
                        <input class="form-control" type="tel" name="mobile"
                            placeholder="{{ __('Enter Your Mobile Number') }}" aria-label=""
                            value="{{ $profile->mobile }}" required>
                        <div class="form-control-icon"><i class="flaticon-telephone"></i></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        <label for="" class="form-label"> {{ __('Email Address') }}<span
                                class="required">*</span></label>
                        <input class="form-control" type="email" name="email"
                            placeholder="{{ __('Please Enter Your Email') }}" aria-label=""
                            value="{{ $profile->email }}" required>
                        <div class="form-control-icon"><i class="flaticon-email"></i></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group gender-form-group">
                        <label for="" class="form-label"> {{ __('Gender') }}<span
                                class="required">*</span></label>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-4">
                                <div class="form-check p-0">
                                    <input class="form-check-input" type="radio" name="gender"
                                        id="flexRadioDefault1" value="m" {{ old('gender',
                                        $profile->gender) === 'm' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        <img src="{{ url('admin_theme/assets/images/gender/male.png') }}"
                                            class="img-fluid" alt="{{ __('male') }}">
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4">
                                <div class="form-check p-0">
                                    <input class="form-check-input" type="radio" name="gender"
                                        id="flexRadioDefault2" value="f" {{ old('gender',
                                        $profile->gender) === 'f' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        <img src="{{ url('admin_theme/assets/images/gender/female.png') }}"
                                            class="img-fluid" alt="{{ __('female') }}">
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4">
                                <div class="form-check p-0">
                                    <input class="form-check-input" type="radio" name="gender"
                                        id="flexRadioDefault3" value="o" {{ old('gender',
                                        $profile->gender) === 'o' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault3">
                                        <img src="{{ url('admin_theme/assets/images/gender/others.png') }}"
                                            class="img-fluid" alt="{{ __('other') }}">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        <label for="" class="form-label"> {{ __('Address') }}</label>
                        <input class="form-control" type="text" name="address"
                            placeholder="{{ __('Address') }}" aria-label=""
                            value="{{ $profile->address }}">
                        <div class="form-control-icon"><i class="flaticon-location"></i></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        <label for="" class="form-label"> {{ __('Zip Code') }}<span
                                class="required">*</span></label>
                        <input class="form-control" type="number" name="pincode"
                            placeholder="{{ __('Please Enter Your Pincode') }}" aria-label=""
                            value="{{ $profile->pincode }}" required>
                        <div class="form-control-icon"><i class="flaticon-email-1"></i></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        <label for="" class="form-label"> {{ __('City') }}<span
                                class="required">*</span></label>
                        <input class="form-control city_id" type="text" name="city"
                            placeholder="{{ __('Please Enter Your City') }}" aria-label="" required
                            onchange="get_state_country(this.value)" value="{{ $profile->city }}">
                            <input type="hidden" name="city_id" class="city_id">
                        <div class="form-control-icon"><i class="flaticon-building"></i></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        <label for="" class="form-label"> {{ __('State') }}<span
                                class="required">*</span></label>
                        <input class="form-control state_id" type="text" name="state"
                            placeholder="{{ __('Please Enter Your State') }} " aria-label=""
                            value="{{ $profile->state }}" readonly>
                            <input type="hidden" name="state_id" class="state_id">
                        <div class="form-control-icon"><i class="flaticon-government"></i></div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        <label for="" class="form-label"> {{ __('Country') }}<span
                                class="required">*</span></label>
                        <input class="form-control country_id" type="text" name="country"
                            placeholder="{{ __('Please Enter Your Country') }}" aria-label=""
                            value="{{ $profile->country }}" readonly>
                            <input type="hidden" name="country_id" class="country_id">
                        <div class="form-control-icon"><i class="flaticon-maps"></i></div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="" class="form-label">
                            {{ __('Descriptions') }}</label>
                        <textarea class="form-control form-control-padding_15" name="desc" id="desc"
                            placeholder="{{ __('Descriptions') }}"
                            id="floatingTextarea">{{ $profile->desc }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="client-detail-block">
            <h5 class="block-heading">{{ __('Portfolio') }}</h5>
            <div class="row">
                @forelse ($socialMedia as $socialMediaData)
                <div class="col-lg-4 col-md-4">
                    <div class="portfolio-options">
                        <?php
                                $iconClass = 'flaticon-government';
                                switch ($socialMediaData->type) {
                                    case 'facebook':
                                        $iconClass = 'flaticon-facebook';
                                        break;
                                    case 'instagram':
                                        $iconClass = 'flaticon-instagram';
                                        break;
                                    case 'twitter':
                                        $iconClass = 'flaticon-twitter';
                                        break;
                                    case 'linkedin':
                                        $iconClass = 'flaticon-linkedin';
                                        break;
                                    case 'youtube':
                                        $iconClass = 'flaticon-youtube';
                                        break;
                                    default:
                                        break;
                                }
                            ?>
                        <div class="form-group">
                            <input class="form-control" type="text" name="social_media_url[]"
                                placeholder="{{ '@' . $socialMediaData->username }}" aria-label=""
                                value="{{ $socialMediaData->url }}">
                            <div class="form-control-icon form-control-icon-one"><i class="{{ $iconClass }}"></i></div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table social-profile-field table-borderless">
                            <tbody>
                                <tr>
                                    <td class="w_42">
                                        <div class="form-group">
                                            <select name="social_media_type[]"
                                                class="form-control course_name">
                                                <option disabled selected>{{ __('Select Social Media
                                                    Type') }}</option>
                                                <option value="default" selected>{{ __('Default') }}
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td class="w_42">
                                        <div class="form-group">
                                            <input type="url" class="form-control"
                                                name="social_media_url[]"
                                                placeholder="{{ __('Enter Social Media Url') }}">
                                            <div class="form-control-icon"><i class="flaticon-link"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="w_16 text-end">
                                        <button class="btn btn-primary text-end addnew" type="button"><i
                                                class="flaticon-plus"></i></button>
                                        <button class="btn btn-danger removeBtn" type="button"><i
                                                class="flaticon-delete"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<button type="submit" class="btn btn-primary update-btn mb-3" title="{{ __('Update') }}">{{ __('Update') }}</button>
</form>
<div class="client-detail-block">
    <h5 class="block-heading"> {{ __('Change Password') }}</h5>
    <form action="{{ route('update.password', ['id' => auth()->user()->id]) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label for="old-password" class="form-label">{{ __('Old Password') }}</label>
                    <input id="old-password" name="old_password" class="form-control" type="password"
                        placeholder="{{ __('Enter Current Password') }}" aria-label="">
                    <div class="form-control-icon"><i class="flaticon-old-key"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label for="new-password" class="form-label">{{ __('New Password') }}</label>
                    <input id="new-password" name="password" class="form-control" type="password"
                        placeholder="{{ __('Enter New Password') }}" aria-label="">
                    <div class="form-control-icon"><i class="flaticon-password"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label for="confirm-password" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="confirm-password" name="confirm_password" class="form-control" type="password"
                        placeholder="{{ __('Confirm Password') }}" aria-label="">
                    <div class="form-control-icon"><i class="flaticon-security"></i></div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" title="{{ __('Update Password') }}">{{ __('Update Password')
            }}</button>
    </form>
</div>
@if (!Auth::check() || (Auth::check() && Auth::user()->role != 'A'))
<div class="client-detail-block">
    <h5 class="block-heading">{{ __('Delete Account') }}</h5>
    <form action="{{ route('request.account.deletion') }}" method="post" id="deleteAccountForm">
        @csrf
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label for="delete-password" class="form-label">{{ __('Password') }}</label>
                    <input id="delete-password" name="password" class="form-control" type="password"
                        placeholder="{{ __('Enter Your Password') }}" aria-label="" required>
                    <div class="form-control-icon"><i class="flaticon-password"></i></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="form-group">
                    <label for="delete-reason" class="form-label">{{ __('Reason for Deletion') }}</label>
                    <select id="delete-reason" name="reason" class="form-control" required>
                        <option value="">{{ __('Select a reason') }}</option>
                        <option value="no_longer_needed">{{ __('No longer needed') }}</option>
                        <option value="privacy_concerns">{{ __('Privacy concerns') }}</option>
                        <option value="not_satisfied">{{ __('Not satisfied with the service') }}</option>
                        <option value="other">{{ __('Other') }}</option>
                    </select>
                    <div class="form-control-icon"><i class="flaticon-select"></i></div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-danger" title="{{ __('Request Account Deletion') }}">{{ __('Request Account Deletion') }}</button>
    </form>
</div>
@endif

<!-- Modal for custom reason -->
<div class="modal fade" id="customReasonModal" tabindex="-1" aria-labelledby="customReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customReasonModalLabel">{{ __('Specify Other Reason') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea id="custom-reason" class="form-control" rows="4"
                    placeholder="{{ __('Please provide your reason for account deletion') }}"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="saveCustomReason">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End Contentbar -->
@endsection

@section('scripts')
<script>
    var getStateCountryUrl = "{{ route('get.state.country') }}";
</script>
<script src="{{ asset('/admin_theme/assets/js/profile.js') }}"></script>
@endsection
