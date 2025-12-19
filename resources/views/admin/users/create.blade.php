@extends('admin.layouts.master')
@section('title', 'Users')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['thirdactive' => 'active'])
            @slot('heading')
                {{ __('Users') }}
            @endslot
            @slot('menu1')
                {{ __('Users') }}
            @endslot
            @slot('menu2')
                {{ __('Create') }}
            @endslot
            @slot('button')
                <div class="col-md-7 col-lg-6">
                    <div class="widget-button">
                        <a href="{{ route('users.show') }}" class="btn btn-primary"><i class="flaticon-back"
                                title="{{ __('Back') }}" required></i>
                            {{ __('Back') }}</a>
                    </div>
                </div>
            @endslot
        @endcomponent

        <div class="contentbar profile-main-block">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12">
                    <!--form code start-->
                    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="client-detail-block">
                            <h5 class="block-heading">{{__('Personal Details')}}</h5>
                            <div class="row">
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="form-label">{{ __('Full Name') }}<span
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
                                        <label for="slug" class="form-label">{{ __('Username') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control @error('slug') is-invalid @enderror" type="text"
                                            name="slug" id="slug" placeholder="{{ __('Please Enter Your Username') }}"
                                            aria-label="slug" value="{{ old('slug') }}" required>
                                        <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                        @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label for="email" class="form-label">{{ __('Email') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                                            name="email" id="email" placeholder="{{ __('Please Enter Your Email') }}"
                                            aria-label="Email" value="{{ old('email') }}" required>
                                        <div class="form-control-icon"><i class="flaticon-email"></i></div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-8 col-md-8 col-8">
                                                        <label for="mobile" class="form-label">{{ __('Mobile No.') }}<span
                                                            class="required">*</span></label>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-4">
                                                        <div class="suggestion-icon float-end">
                                                            <div class="tooltip-icon">
                                                                <div class="tooltip">
                                                                    <div class="credit-block">
                                                                        <small
                                                                            class="recommended-font-size">{{ __('Put Country code before Number') }}</small>
                                                                    </div>
                                                                </div>
                                                                <span class="float-end"><i class="flaticon-info"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <input class="form-control @error('mobile') is-invalid @enderror" type="number"
                                            name="mobile" id="mobile" placeholder="{{ __('Enter Your Mobile No.') }}"
                                            aria-label="Mobile" value="{{ old('mobile') }}" required>
                                        <div class="form-control-icon"><i class="flaticon-telephone"></i></div>
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-8">
                                                <label for="image" class="form-label">{{ __('Image') }}<span
                                                        class="required">*</span></label>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-4">
                                                <div class="suggestion-icon float-end">
                                                    <div class="tooltip-icon">
                                                        <div class="tooltip">
                                                            <div class="credit-block">
                                                                <small
                                                                    class="recommended-font-size">{{ __('Recommended Size: 40X40px') }}</small>
                                                            </div>
                                                        </div>
                                                        <span class="float-end"><i class="flaticon-info"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input class="form-control @error('image') is-invalid @enderror" type="file"
                                            name="image" id="image" accept="image/*">
                                        <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label for="role" class="form-label">{{ __('Select User Role ') }}<span
                                                class="required">*</span></label>
                                        <select class="form-select @error('role') is-invalid @enderror" aria-label="Role"
                                            name="role" id="role">
                                            <option selected disabled>{{ __('Select Role') }}</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    {{ old('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="form-control-icon"><i class="flaticon-role"></i></div>
                                        @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label for="age" class="form-label">{{ __('Age') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control @error('age') is-invalid @enderror" type="number"
                                            name="age" id="age" placeholder="{{ __('Please Enter Your Age') }}"
                                            aria-label="age" value="{{ old('age') }}" required>
                                        <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group gender-form-group">
                                        <label for="" class="form-label"> {{ __('Gender') }}<span
                                                class="required">*</span></label>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-4">
                                                <div class="form-check p-0">
                                                    <input class="form-check-input @error('gender') is-invalid @enderror"
                                                        type="radio" name="gender" id="male" value="m"
                                                        {{ old('gender', 'm') == 'm' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="male">
                                                        <img src="{{ url('admin_theme/assets/images/gender/male.png') }}"
                                                            class="img-fluid version-img" alt="{{ __('male') }}" required>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-4">
                                                <div class="form-check p-0">
                                                    <input class="form-check-input @error('gender') is-invalid @enderror"
                                                        type="radio" name="gender" id="female" value="f"
                                                        {{ old('gender') == 'f' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="female">
                                                        <img src="{{ url('admin_theme/assets/images/gender/female.png') }}"
                                                            class="img-fluid version-img" alt="{{ __('female') }}" required>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-4">
                                                <div class="form-check p-0">
                                                    <input class="form-check-input @error('gender') is-invalid @enderror"
                                                        type="radio" name="gender" id="other" value="o"
                                                        {{ old('gender') == 'o' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="other">
                                                        <img src="{{ url('admin_theme/assets/images/gender/others.png') }}"
                                                            class="img-fluid version-img" alt="{{ __('other') }}" required>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label for="password" class="form-label">{{ __('Password') }}<span
                                                class="required">*</span></label>
                                        <input id="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            type="password" placeholder="{{ __('Enter Your Password') }}"
                                            aria-label="Password" name="password">
                                        <i id="togglePassword" class="flaticon-view field-icon toggle-password"
                                            onclick="togglePasswordVisibility()"></i>
                                        <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3">
                                    <div class="form-group">
                                        <label for="confirm_password"
                                            class="form-label">{{ __('Confirm Password') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control @error('confirm_password') is-invalid @enderror"
                                            type="password" placeholder="{{ __('Confirm Password') }}"
                                            aria-label="Confirm Password" name="confirm_password">
                                        <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                        @error('confirm_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-check form-switch ">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                                name="status" value="1" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="client-detail-block">
                            <h5 class="block-heading">{{__('Address')}}</h5>
                            <div class="row">
                                <div class="col-lg-8 col-md-8">
                                    <div class="form-group">
                                        <label for="address" class="form-label">{{ __('Address') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control @error('address') is-invalid @enderror" type="text"
                                            name="address" id="address"
                                            placeholder="{{ __('Please Enter Your Address') }}" aria-label="Address"
                                            value="{{ old('address') }}" required>
                                        <div class="form-control-icon"><i class="flaticon-location"></i></div>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label for="pincode" class="form-label">{{ __('Pincode') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control @error('pincode') is-invalid @enderror" type="number"
                                            name="pincode" id="pincode"
                                            placeholder="{{ __('Please Enter Your Pincode') }}" aria-label="Pincode"
                                            value="{{ old('pincode') }}" required>
                                        <div class="form-control-icon"><i class="flaticon-email-1"></i></div>
                                        @error('pincode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label for="city" class="form-label">{{ __('City') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control city_id @error('city') is-invalid @enderror"
                                            type="text" name="city" id="city"
                                            placeholder="{{ __('Please Enter Your City Name') }}" aria-label="City"
                                            value="{{ old('city') }}" onchange="get_state_country(this.value)"
                                            required>
                                        <div class="form-control-icon"><i class="flaticon-building"></i></div>
                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label for="state" class="form-label">{{ __('State') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control state_id @error('state') is-invalid @enderror"
                                            type="text" name="state" id="state"
                                            placeholder="Please Enter Your State Name" aria-label="State"
                                            value="{{ old('state') }}">
                                        <div class="form-control-icon"><i class="flaticon-government"></i></div>
                                        @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label for="country" class="form-label">{{ __('Country') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control country_id @error('country') is-invalid @enderror"
                                            type="text" name="country" id="country"
                                            placeholder="Please Enter Your Country Name" aria-label="Country"
                                            value="{{ old('country') }}" required>
                                        <div class="form-control-icon"><i class="flaticon-maps"></i></div>
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="client-user-detail-block">
                            <div id="dynamic-form">
                                <h5 class="block-heading">{{ __('Social Profile') }}<span
                                                class="required">*</span></h5>
                                <div class="table-responsive">
                                    <table class="table social-profile-field table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="w_42">
                                                    <div class="form-group m-3">
                                                        <select name="social_media_type[]"
                                                            class="form-select course_name @error('social_media_type.0') is-invalid @enderror">
                                                            <option disabled selected> {{ __('Select Social Media Type') }}
                                                            </option>
                                                            <option value="facebook"
                                                                {{ old('social_media_type.0') == 'facebook' ? 'selected' : '' }}>
                                                                {{ __('Facebook') }}</option>
                                                            <option value="youtube"
                                                                {{ old('social_media_type.0') == 'youtube' ? 'selected' : '' }}>
                                                                {{ __('YouTube') }}</option>
                                                            <option value="twitter"
                                                                {{ old('social_media_type.0') == 'twitter' ? 'selected' : '' }}>
                                                                {{ __('Twitter') }}</option>
                                                            <option value="linkedIn"
                                                                {{ old('social_media_type.0') == 'linkedIn' ? 'selected' : '' }}>
                                                                {{ __('LinkedIn') }}</option>
                                                            <option value="instagram"
                                                                {{ old('social_media_type.0') == 'instagram' ? 'selected' : '' }}>
                                                                {{ __('Instagram') }}</option>
                                                            <option value="other"
                                                                {{ old('social_media_type.0') == 'other' ? 'selected' : '' }}>
                                                                {{ __('Other') }}</option>
                                                        </select>
                                                        <div class="form-control-icon"><i class="flaticon-digital-marketing"></i></div>
                                                        @error('social_media_type.0')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td class="w_42">
                                                    <div class="form-group m-3">
                                                        <input type="url"
                                                            class="form-control @error('social_media_url.0') is-invalid @enderror"
                                                            name="social_media_url[]" placeholder="Enter Social Media Url"
                                                            value="{{ old('social_media_url.0') }}" required>
                                                        <div class="form-control-icon"><i class="flaticon-link"></i></div>
                                                        @error('social_media_url.0')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td class="w_16 text-end m-3">
                                                    <button class="btn btn-primary text-end addnew m-3" type="button"><i
                                                            class="flaticon-plus"></i></button>
                                                    <button class="btn btn-danger removeBtn" type="button"><i
                                                            class="flaticon-delete"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary"><i
                                class="flaticon-upload-1"></i> {{ __('Submit') }}</button>
                    </form>
                    <!-- form code end -->
                </div>
            </div>
        </div>
    </div>
@endsection

