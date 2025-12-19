@extends('admin.layouts.master')
@section('title', 'SEO Settings')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
        @slot('heading') {{ __('SEO Settings ') }} @endslot
        @slot('menu1') {{ __('Front Settings') }} @endslot
        @slot('menu2') {{ __('SEO Settings ') }} @endslot
    @endcomponent

    <div class="contentbar profile-main-block">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <!--form code start-->
                <form id="seo-form" action="{{ route('seo_setting.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="meta_desc" class="form-label">
                                        {{ __('Meta Data Description :') }}
                                        <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control form-control-padding_15"
                                        name="meta_data_desc"
                                        id="meta_desc"
                                        cols="30"
                                        rows="5"
                                        placeholder="{{ __('Enter description') }}"
                                        required>{{ $seosettings ? strip_tags($seosettings->meta_data_desc) : "" }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="meta_keywords" class="form-label">
                                        {{ __('Meta Data Keywords (comma separate) :') }}
                                        <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control form-control-padding_15"
                                        name="meta_data_keyword"
                                        id="meta_keywords"
                                        cols="30"
                                        rows="5"
                                        placeholder="{{ __('Use Comma to seprate keyword') }}"
                                        required>{{ $seosettings ? strip_tags($seosettings->meta_data_keyword) : "" }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="reset" class="btn btn-secondary" title="{{ __('Reset') }}">
                        <i class="flaticon-refresh"></i> {{ __("Reset") }}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="flaticon-upload-1"></i> {{ __('Submit') }}
                    </button>
                </form>
                <!-- form code end -->
            </div>
        </div>
    </div>
</div>

<div id="resetSuccess" class="alert alert-success d-none mt-3">
    {{ __('Form reset successfully!') }}
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const resetBtn = document.querySelector('button[type="reset"]');
    const resetSuccessMsg = document.getElementById('resetSuccess');

    resetBtn.addEventListener('click', function (e) {
        e.preventDefault();

        const form = this.closest('form');
        form.reset();

        form.querySelectorAll('textarea, input[type="text"], input[type="email"]').forEach(el => {
            el.value = '';
        });

        // Show success message
        resetSuccessMsg.classList.remove('d-none');

        // Hide after 3 seconds
        setTimeout(() => {
            resetSuccessMsg.classList.add('d-none');
        }, 3000);
    });
});
</script>

{{-- JavaScript to manually reset textarea content --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const resetBtn = document.querySelector('button[type="reset"]');
    resetBtn.addEventListener('click', function (e) {
        e.preventDefault(); // prevent native reset
        const form = this.closest('form');
        form.reset(); // does default reset first

        // then blank manually filled fields
        form.querySelectorAll('textarea, input[type="text"], input[type="email"]').forEach(el => {
            el.value = '';
        });
    });
});
</script>

@endsection
