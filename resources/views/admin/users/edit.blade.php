@extends('admin.layouts.master')
@section('title', 'Users')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Users ') }}
    @endslot
    @slot('menu1')
    {{ __('Users ') }}
    @endslot
    @slot('menu2')
    {{ __('Edit ') }}
    @endslot

    @slot('button')
    <div class="col-md-7 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('users.show') }}" class="btn btn-primary"><i class="flaticon-back"
                    title="{{ __('Back') }}"></i>
                {{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent

    <div class="contentbar profile-main-block">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ url('admin/users/' . $user->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    
                    <div class="client-detail-block">
                        <h5 class="block-heading">{{ __('Personal Details ') }}</h5>
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="heading" class="form-label">{{ __('Full Name') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control" type="text" name="name" id="heading"
                                        placeholder="{{ __('Please Enter Your Name') }}" aria-label="Heading"
                                        value="{{ isset($user->name) ? $user->name : '' }}">
                                    <div class="form-control-icon"><i class="flaticon-user"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="email" class="form-label">{{ __('Email') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control" type="email" name="email"
                                        placeholder="{{ __('Please Enter Your Email') }}" aria-label="Slug"
                                        value="{{ isset($user->email) ? $user->email : '' }}">
                                    <div class="form-control-icon"><i class="flaticon-email"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="mobile" class="form-label">{{ __('Mobile No.') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control" type="number" name="mobile"
                                        placeholder="{{ __('Please Enter Your Mobile Number') }}" aria-label="Slug"
                                        value="{{ isset($user->mobile) ? $user->mobile : '' }}">
                                    <div class="form-control-icon"><i class="flaticon-telephone"></i></div>
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
                                                            <small class="recommended-font-size">{{ __('Recommended Size
                                                                :
                                                                40X40px') }}</small>
                                                        </div>
                                                    </div>
                                                    <span class="float-end"><i class="flaticon-info"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-8">
                                            <input class="form-control" type="file" name="image" id="images"
                                                accept="image/*" onchange="readURL(this);">
                                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="edit-img-show">
                                                @if (!empty($user->image))
                                                <img src="{{ asset('/images/users/' . $user->image) }}"
                                                    alt="{{ __('user img') }}" class="img-fluid" id="image">
                                                @else
                                                <img src="{{ Avatar::create($user->name)->toBase64() }}" alt="{{ __('user img') }}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="slug" class="form-label">{{ __('Select User Role ') }}<span
                                            class="required">*</span></label>
                                    <select class="form-select" aria-label=" " name="role">
                                        <option selected disabled>{{ __('Select Role') }}</option>
                                        @foreach ($roles as $role)
                                        <option {{ $user->getRoleNames()->contains($role->name) ? 'selected' : "" }}
                                            value="{{ $role->name}}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-control-icon"><i class="flaticon-role"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group gender-form-group">
                                    <label for="" class="form-label"> {{ __('Gender') }}<span
                                            class="required">*</span></label>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="form-check p-0">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="flexRadioDefault1" value="m" {{ old('gender', $user->gender) ==='m' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    <img src="{{ url('admin_theme/assets/images/gender/male.png') }}"
                                                        class="img-fluid version-img" alt="{{ __('male') }}">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="form-check p-0">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="flexRadioDefault2" value="f" {{ old('gender', $user->gender) ==='f' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    <img src="{{ url('admin_theme/assets/images/gender/female.png') }}"
                                                        class="img-fluid version-img" alt="{{ __('female') }}">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4">
                                            <div class="form-check p-0">
                                                <input class="form-check-input" type="radio" name="gender"
                                                    id="flexRadioDefault3" value="o" {{ old('gender', $user->gender) ==='o' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexRadioDefault3">
                                                    <img src="{{ url('admin_theme/assets/images/gender/others.png') }}"
                                                        class="img-fluid version-img" alt="{{ __('other') }}">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">{{ __('Password') }}<span
                                            class="required">*</span></label>
                                    <input id="password" class="form-control form-control-lg" type="Password"
                                        placeholder="{{ __('Please Enter Your Password') }}" aria-label=""
                                        name="password">
                                    <i id="togglePassword" class="flaticon-view field-icon toggle-password"
                                        onclick="togglePasswordVisibility()"></i>
                                    <div class="form-control-icon"><i class="flaticon-password"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">{{ __('Confirm Password') }}<span
                                            class="required">*</span></label>
                                    <input id="confirm_password" class="form-control form-control-lg" type="Password"
                                        placeholder="{{ __('Please Enter Confirm Password') }}" aria-label=""
                                        name="password">
                                    <i id="togglePasswordConfirmation" class="flaticon-view field-icon toggle-password"
                                        onclick="togglePasswordVisibility1()"></i>
                                    <div class="form-control-icon"><i class="flaticon-security"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="desc" class="form-label">{{ __('Details') }}</label>
                                    <textarea class="form-control form-control-padding_15" name="desc" id="desc" rows="2"
                                        placeholder="{{ __('Please Enter Your Details') }}">{{ $user->desc }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="statusToggle"
                                            name="status" value="1" {{ $user->status == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="client-detail-block">
                        <h5 class="block-heading">{{ __('Address') }}</h5>
                        <div class="row">
                            <div class="col-lg-8 col-md-8">
                                <div class="form-group">
                                    <label for="hedaing" class="form-label">{{ __('Address') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control form-control-lg" type="text" name="address"
                                        placeholder="{{ __('Please Enter Your Address') }}" aria-label="address"
                                        value="{{ $user->address }}">
                                    <div class="form-control-icon"><i class="flaticon-location"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="slug" class="form-label">{{ __('Pincode') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control form-control-lg" type="text" name="pincode"
                                        placeholder="{{ __('Please Enter Your Pincode') }}" aria-label="pincode"
                                        value="{{ $user->pincode }}">
                                    <div class="form-control-icon"><i class="flaticon-email-1"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="slug" class="form-label">{{ __('City') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control form-control" type="text" name="city"
                                        placeholder="{{ __('Please Enter Your City Name') }}" aria-label="city" required value="{{ $user->city }}">
                                    <div class="form-control-icon"><i class="flaticon-building"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="slug" class="form-label">{{ __('State') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control form-control-lg state_id" type="text" name="state"
                                        placeholder="{{ __('Please Enter Your State Name') }}" aria-label="state" value="{{ $user->state }}">
                                    <div class="form-control-icon"><i class="flaticon-government"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group">
                                    <label for="slug" class="form-label">{{ __('Country') }}<span
                                            class="required">*</span></label>
                                    <input class="form-control form-control-lg country_id" type="text" name="country"
                                        placeholder="{{ __('Please Enter Your Country Name') }}" aria-label="country" value="{{ $user->country }}">
                                    <div class="form-control-icon"><i class="flaticon-maps"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="client-user-detail-block">
                        <div id="dynamic-form">
                            <h5 class="block-heading"> {{ __('Social Profile') }}</h5>
                            <div class="table-responsive">
                                <table class="table social-profile-field table-borderless">
                                    <tbody>
                                        @forelse ($socialMediaData as $socialMedia)
                                        <tr>
                                            <td class="w_42">
                                                <div class="form-group m-3">
                                                    <select name="social_media_type[]" class="form-select course_name">
                                                        <option disabled selected>{{ __('Select Social Media Type') }}
                                                        </option>
                                                        <option value="facebook" {{ old('social_media_type',
                                                            $socialMedia->type) === 'facebook' ? 'selected' : '' }}>
                                                            {{ __('Facebook') }}
                                                        </option>
                                                        <option value="youtube" {{ old('social_media_type',
                                                            $socialMedia->type) === 'youtube' ? 'selected' : '' }}>
                                                            {{ __('YouTube') }}
                                                        </option>
                                                        <option value="twitter" {{ old('social_media_type',
                                                            $socialMedia->type) === 'twitter' ? 'selected' : '' }}>
                                                            {{ __('Twitter') }}
                                                        </option>
                                                        <option value="linkedIn" {{ old('social_media_type',
                                                            $socialMedia->type) === 'linkedIn' ? 'selected' : '' }}>
                                                            {{ __('LinkedIn') }}
                                                        </option>
                                                        <option value="instagram" {{ old('social_media_type',
                                                            $socialMedia->type) === 'instagram' ? 'selected' : '' }}>
                                                            {{ __('Instagram') }}
                                                        </option>
                                                        <option value="other" {{ old('social_media_type', $socialMedia->
                                                            type) === 'other' ? 'selected' : '' }}>
                                                            {{ __('Other') }}
                                                        </option>
                                                    </select>
                                                     <div class="form-control-icon"><i class="flaticon-digital-marketing"></i></div>
                                                </div>
                                            </td>
                                            <td class="w_42">
                                                <div class="form-group m-3">
                                                    <input type="url" class="form-control" name="social_media_url[]"
                                                        placeholder="{{ __('Enter Social Media Url') }}"
                                                        value="{{ $socialMedia->url }}">
                                                    <div class="form-control-icon"><i class="flaticon-link"></i></div>
                                                </div>
                                            </td>
                                            <td class="w_16 text-end m-3">
                                                <button class="btn btn-primary text-end addnew m-3" type="button"><i
                                                        class="flaticon-plus"></i></button>
                                                <button class="btn btn-danger removeBtn" type="button"><i
                                                        class="flaticon-delete"></i></button>
                                            </td>
                                        </tr>
                                        @empty
                                        <!-- Default input box when there is no social media data -->
                                        <tr>
                                            <td class="w_42">
                                                <div class="form-group m-3">
                                                    <select name="social_media_type[]" class="form-select course_name">
                                                        <option disabled selected> {{ __('Select Social Media Type') }}
                                                        </option>
                                                        <option value="facebook"> {{ __('Facebook') }}</option>
                                                        <option value="youtube"> {{ __('YouTube') }}</option>
                                                        <option value="twitter"> {{ __('Twitter') }}</option>
                                                        <option value="linkedIn"> {{ __('LinkedIn') }}</option>
                                                        <option value="instagram"> {{ __('Instagram') }}</option>
                                                        <option value="other"> {{ __('Other') }}</option>
                                                    </select>
                                                    <div class="form-control-icon"><i class="flaticon-digital-marketing"></i></div>
                                                </div>
                                            </td>
                                            <td class="w_42">
                                                <div class="form-group m-3">
                                                    <input type="url" class="form-control" name="social_media_url[]"
                                                        placeholder="{{ __('Enter Social Media Url') }}">
                                                    <div class="form-control-icon"><i class="flaticon-link"></i></div>
                                                </div>
                                            </td>
                                            <td class="w_16 text-end m-3">
                                                <button class="btn btn-primary text-end addnew m-3" type="button"><i
                                                        class="flaticon-plus"></i></button>
                                                <button class="btn btn-danger removeBtn" type="button"><i
                                                        class="flaticon-delete"></i></button>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" title="{{ __('Update') }}"><i class="flaticon-upload-1"></i>{{ __('Update') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Delete Modal start -->
<div class="modal fade" id="bulk_delete" tabindex="-1" aria-labelledby="bulkDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bulkDeleteLabel">{{ __('Delete Selected Records') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    title="{{ __('Close') }}"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('Do you really want to delete the selected records? This action cannot be undone.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="{{ __('No') }}">{{
                    __('No') }}</button>
                <form id="bulk_delete_form" method="post" action="{{ route('slider.bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger" title="{{ __('Yes') }}">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bulk Delete Modal end -->
@endsection
