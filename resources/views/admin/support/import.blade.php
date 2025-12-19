@extends('admin.layouts.master')
@section('title', 'Import Demo')
@section('main-container')
    <div class="dashboard-card">
        @component('admin.components.breadcumb',['thirdactive' => 'active'])
        @slot('heading')
        {{ __('Import Demo') }}
        @endslot
        @slot('menu1')
        {{ __('Help & Support') }}
        @endslot
        @slot('menu2')
        {{ __('Import Demo') }}
        @endslot
        @endcomponent

        <div class="contentbar">
            @include('admin.layouts.flash_msg')

            <div class="row">
                <div class="col-lg-12">
                    <!-- form code start -->
                        <div class="client-detail-block">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <small class="text-danger process-fonts"><i class="flaticon-info"></i>
                                            {{ __('Important Note') }}
                                            <ul class="pwa-text-widget">
                                                <li>
                                                    {{ __('Please take a Backup first.') }}
                                                </li>
                                                <li>
                                                    {{ __('ON Click of import data your existing data will remove (except users & settings)') }}
                                                </li>
                                                <li>
                                                    {{ __('Upon clicking Reset Demo, your site (which you see after a fresh install) will be reset. It erases your Demo data and gives a blank site.') }}
                                                </li>
                                                <li>
                                                    {{ __('You will only receive placeholder images in the demo data.') }}
                                                </li>
                                                <li>
                                                    {{ __('Demo data refers to sample or placeholder data that is used for demonstration or testing purposes. It is used to show how LMS works or to test the functionality of a script project.') }}
                                                </li>
                                            </ul>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                 <a href="{{ route('reset.database') }}" class="btn btn-danger  mt-3 " title="{{ __('Reset Demo') }}"><i class="flaticon-restore"></i>{{ __('Reset Demo') }}</a>
                                <a href="{{ route('import.database') }}" class="btn btn-primary  mt-3 me-2" title="{{ __('Import Demo') }}"><i class="flaticon-import" ></i>{{ __('Import Demo') }}</a>
                                </div>
                        </div>
                    <!---form code end ---->
                </div>
            </div>
        </div>
    </div>
@endsection
