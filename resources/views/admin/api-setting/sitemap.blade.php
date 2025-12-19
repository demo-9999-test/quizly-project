@extends('admin.layouts.master') 
@section('title', 'Sitemap')

@section('main-container')
<div class="dashboard-card">

    @component('admin.components.breadcumb',['thirdactive' => 'active'])
        @slot('heading')
            {{ __('Sitemap') }}
        @endslot
        @slot('menu1')
            {{ __('Front Panel') }}
        @endslot
        @slot('menu2')
            {{ __('Sitemap') }}
        @endslot
    @endcomponent

    <div class="contentbar bardashboard-card">
        @include('admin.layouts.flash_msg')

        <div class="client-detail-block">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 text-center bg-white p-4 rounded shadow-sm">
                    <form action="{{ route('generate-sitemap') }}" method="post" enctype="multipart/form-data" class="mb-3">
                        @csrf
                        <button type="submit" title="{{ __('Generate Sitemap') }}" class="btn btn-primary w-100">
                            <i class="flaticon-refresh"></i> {{ __('Generate Sitemap') }}
                        </button>
                    </form>

                    <form action="{{ route('download-sitemap') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="flaticon-upload-1"></i> {{ __('Download') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
