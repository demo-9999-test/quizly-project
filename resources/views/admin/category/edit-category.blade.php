@extends('admin.layouts.master')
@section('title', 'Category Edit')
@section('main-container')

<div class="dashboard-card">

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-main-block" aria-label="breadcrumb">
        <div class="row">
            <div class="col-lg-6">
                <div class="breadcrumbbar">
                    <h4 class="page-title">{{ __('Category') }}</h4>
                    <div class="breadcrumb-list">
                        <ol class="breadcrumb d-flex">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin/dashboard') }}" title="{{ __('Dashboard') }}">{{ __('Dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item">{{ __('Categories') }}</li>
                            <li class="breadcrumb-item">{{ __('Edit') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-end">
                <div class="widget-button">
                    <a href="{{ route('category.index') }}" class="btn btn-primary" title="{{ __('Back') }}">
                        <i class="flaticon-back"></i> {{ __('Back') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Breadcrumb End -->

    <!-- Start Contentbar -->
    <div class="contentbar">
        @include('admin.layouts.flash_msg')

        <div class="client-detail-block">
            <div class="registration-block">

                <!-- Form Start -->
                <form action="{{ route('post-category.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" value="{{ $category->id }}">

                    <div class="row">

                        <!-- Category Name -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="title" class="form-label">{{ __('Category') }} <span class="required">*</span></label>
                                <input class="form-control" type="text" name="name" id="title" required
                                    value="{{ old('name', $category->name) }}"
                                    placeholder="Enter Your Category" aria-label="Category">
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="slug" class="form-label">{{ __('Slug') }} <span class="required">*</span></label>
                                <input class="form-control custom-input" type="text" name="slug" id="slug"
                                    value="{{ old('slug', $category->slug) }}"
                                    placeholder="Enter Your Slug" aria-label="Slug" required>
                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                            </div>
                        </div>

                        <!-- Category Type -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="categorytype" class="form-label">{{ __('Category Type') }}</label>
                                <select name="categorytype" id="categorytype" class="form-control">
                                    <option value="">Select Category Type</option>
                                    <option value="-1" {{ $category->parent_id == '-1' ? 'selected' : '' }}>
                                        {{ __('Category') }}
                                    </option>
                                    <option value="sub" {{ $category->categorytype == 'sub' ? 'selected' : '' }}>
                                        {{ __('Sub Category') }}
                                    </option>
                                    <option value="child" {{ $category->categorytype == 'child' ? 'selected' : '' }}>
                                        {{ __('Child Sub Category') }}
                                    </option>
                                </select>
                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                            </div>

                            <!-- Parent Category -->
                            <div class="form-group">
                                <label for="sub_category_id" class="form-label">{{ __('Parent Category') }}</label>
                                <select class="form-select select2-multi-select" name="sub_category_id[]" multiple>
                                    <option value="">None</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}"
                                            @if (is_array($category->sub_category_id) && in_array($item->id, $category->sub_category_id)) selected @endif>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="desc" class="form-label">{{ __('Description') }}</label>
                                <textarea class="form-control" name="description" id="desc" cols="30" rows="5"
                                    placeholder="{{ __('Enter description') }}">{{ old('description', $category->description) }}</textarea>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="status_toggle" class="form-label">{{ __('Status') }}</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" id="status_toggle"
                                        {{ $category->status == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-lg-12">
                            <div class="form-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <i class="flaticon-upload-1"></i> {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Session Messages -->
                @if (session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif

            </div>
        </div>
    </div>
    <!-- End Contentbar -->

</div>
@endsection
