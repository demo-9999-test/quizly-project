@extends('admin.layouts.master')
@section('title', 'Activity Logs')
@section('main-container')
    <!-- Dashboard card start-->
    <div class="dashboard-card">
        <!-- Breadcrumb Start -->
        <nav class="breadcrumb-main-block" aria-label="breadcrumb">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumbbar">
                        <h4 class="page-title"> {{ __('Activity Logs') }} </h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb d-flex">
                                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}" title={{__('Dashboard') }}>{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item "> {{ __('Users') }}</li>
                                <li class="breadcrumb-item "> {{ __('Activity Logs') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Breadcrumb End -->
        <div class="contentbar ">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12">
                    <div class="client-detail-block user-page">
                        <div class="table-responsive">
                            <!-- Table start-->
                            <table class="table data-table display" id="example">
                                <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('	User Name') }}</th>
                                        <th>{{ __('IP Address') }}</th>
                                        <th>{{ __('Platform') }}</th>

                                        <th>{{ __('Logged In At') }}</th>
                                        <th>{{ __('Logged Out At') }}</th>
                                    </tr>
                                </thead>
                                <!-- loop  Print data show Start --->
                                <tbody>
                                    @if ($authentication_logs)
                                        @foreach ($authentication_logs as $data)
                                            @if (Auth::check() && Auth::user()->role == 'Admin' && Auth::user()->id != $data->id)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" form="bulk_delete_form"
                                                            class="check filled-in material-checkbox-input form-check-input"
                                                            name="checked[]" value="{{ $data->id }}"
                                                            id="checkbox{{ $data->id }}">
                                                    </td>
                                                    <td>
                                                        <ul>
                                                            <li><strong>{{ __('Name:') }}</strong>
                                                                {{ $data->user['name'] }}</li>
                                                            <li><strong>{{ __('Email:') }}</strong><a
                                                                    href="mailto:{{ $data->email }}"
                                                                    title="{{ __('Email:') }}">
                                                                    {{ $data->user['email'] }}</a></li>
                                                        </ul>
                                                    </td>

                                                    <td>
                                                        {{ $data->ip_address }}
                                                    </td>

                                                    <td>
                                                        {{ $data->user_agent }}
                                                    </td>

                                                    <td>
                                                        {{ date('d/m/Y | h:i A', strtotime($data->login_at)) }}
                                                    </td>
                                                    <td>
                                                        {{ date('d/m/Y | h:i A', strtotime($data->logout_at)) }}
                                                    </td>
                                                </tr>
                                            @endif
                                            {{-- -------------model Start ------------------- --}}
                                            <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                {{ __('Are You Sure ?') }}</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('Do you really want to delete') }} ?
                                                                {{ __('This process cannot be undone.') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="post"
                                                                action="{{ url('admin/users/' . $data->id . '/delete') }}"
                                                                class="pull-right">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">{{ __('No') }}</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">{{ __('Yes') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- ------------- model end ------------------------- --}}
                                        @endforeach
                                        <!------------------------------ loop Print data show end----------------------------->
                                    @endif
                                </tbody>
                            </table>
                            <!-- Table end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard card end-->
     <!-- Bulk Delete Modal start -->
    <div class="modal fade" id="bulk_delete" tabindex="-1" aria-labelledby="bulkDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="bulkDeleteLabel">{{ __('Delete Selected Records') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Do you really want to delete the selected records? This action cannot be undone.') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No') }}</button>
                    <form id="bulk_delete_form" method="post" action="{{ route('users.bulk_delete') }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bulk Delete Modal end -->
@endsection
