<nav class="breadcrumb-main-block" aria-label="breadcrumb">
    <div class="row">
        <div class="col-lg-6 col-md-5">
            <div class="breadcrumbbar mb-3">
                <h4 class="page-title">{{ $heading ?? '' }} </h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb d-flex">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" title="{{__('Dashboard')}}">{{ __('Dashboard') }}</a></li>
                        @if (isset($menu1))
                            <li class="breadcrumb-item {{ $secondaryactive ?? '' }}">{{ $menu1 ?? '' }}</li>
                        @endif
                        @if (isset($menu2))
                            <li class="breadcrumb-item {{ $thirdactive ?? '' }}">{{ $menu2 ?? '' }}</li>
                        @endif
                        @if (isset($menu3))
                            <li class="breadcrumb-item {{ $fourthactive ?? '' }}">{{ $menu3 ?? '' }}</li>
                        @endif
                        @if (isset($menu4))
                            <li class="breadcrumb-item {{ $fifthactive ?? '' }}">{{ $menu4 ?? '' }}</li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
            {{ $button ?? '' }}
    </div>
</nav>
