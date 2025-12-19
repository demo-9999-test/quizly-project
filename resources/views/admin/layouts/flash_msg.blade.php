<!-- Massage Print Code Start -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
<div class="alert-box alert alert-success">
    <div class="row align-items-center">
        <div class="col-lg-2">
            <i class="flaticon-check-2"></i>
        </div>
        <div class="col-lg-10">
            <h6 class="alert-title success-title">{{__('Success')}}</h6>
            <p class="alert-txt success-txt">{{ session('success') }}</p>
        </div>
    </div>
</div>
@elseif (session('error'))
<div class="alert-box alert alert-error">
    <div class="row align-items-center">
        <div class="col-lg-2 text-center">
            <i class="flaticon-cancel"></i>
        </div>
        <div class="col-lg-10">
            <h6 class="alert-title error-title">{{__('Error')}}</h6>
            <p class="alert-txt error-txt">{{ session('error') }}</p>
        </div>
    </div>
</div>
@elseif (session('warning'))
<div class="alert-box alert alert-warning">
    <div class="row align-items-center">
        <div class="col-lg-2 text-center">
            <i class="flaticon-warning"></i>
        </div>
        <div class="col-lg-10">
            <h6 class="alert-title warning-title">{{__('Warning')}}</h6>
            <p class="alert-txt warning-txt">{{ session('warning') }}</p>
        </div>
    </div>
</div>
@elseif (session('delete'))
<div class="alert-box alert alert-error">
    <div class="row align-items-center">
        <div class="col-lg-2 text-center">
            <i class="flaticon-delete"></i>
        </div>
        <div class="col-lg-10">
            <h6 class="alert-title error-title">{{__('Delete')}}</h6>
            <p class="alert-txt error-txt">{{ session('delete') }}</p>
        </div>
    </div>
</div>
@endif
<!-- Massage Print Code end -->
