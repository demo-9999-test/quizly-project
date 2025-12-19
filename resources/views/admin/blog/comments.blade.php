@extends('admin.layouts.master')
@section('title', 'Blog comment')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
            @slot('heading')
                {{ __('Blog comments') }}
            @endslot
            @slot('menu1')
                {{ __('Blog comments') }}
            @endslot
        @endcomponent

        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12">
                    <div class="client-detail-block">
                        <div class="table-responsive">
                            <!--Table Start-->
                            <table  class="table data-table table-borderless"  id="example">
                                <thead>
                                    <tr>
                                        <th>{{ __('#')}}</th>
                                        <th>{{ __('Blog') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Comment') }}</th>
                                        <th>{{ __('Approved') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter =1
                                    @endphp
                                    @foreach ($blog as $data)
                                    <tr>
                                        <td>{{$counter++}}</td>
                                        <td>{{$data->blog->title}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->email}}</td>
                                        <td>{{$data->comment}}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.comments.toggle', $data->id) }}" >
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="flexSwitchCheck{{ $data->id }}"
                                                        onchange="this.form.submit()"{{ $data->approved ? 'checked' : '' }}>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
