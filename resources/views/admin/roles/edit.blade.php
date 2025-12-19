@extends('admin.layouts.master')
@section('title', 'Roles & Permissions')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Roles & Permissions ') }}
    @endslot
    @slot('menu1')
    {{ __('Roles & Permissions') }}
    @endslot
    @slot('menu2')
    {{ __('Edit ') }}
    @endslot

    @slot('button')
    <div class="col-md-7 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('roles.show') }}" class="btn btn-primary" title="{{ __('Back') }}"><i
                    class="flaticon-back"></i>
                {{ __('Back') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent

        <div class="contentbar ">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12">
                    <!-- form code start -->
                    <form action="{{ url('admin/roles/' . $role->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="client-detail-block">
                            <h5 class="block-heading"> {{ __('Create a New Role') }}</h5>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="headaing" class="form-label">{{ __('Role name ') }}<span
                                                class="required">*</span></label>
                                        <input class="form-control form-control-lg" type="text" name="name"
                                            id="name" placeholder="{{ __('Please Enter Role Name') }}" aria-label="Name"
                                            value="{{ $role->name }}">
                                        <div class="form-control-icon"><i class="flaticon-role"></i></div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="block-heading mt-3">{{ __('Assign Permissions to Role') }}</h5>
                            {{-- table code  start  --}}
                            <table class="table data-table permissionTable" id="data-table">
                                <thead>
                                    <th class="w_20">
                                        {{ __('Section') }}
                                    </th>
                                    <th class="w_20">
                                        <label>
                                            <input class="grand_selectall form-check-input" id="grand_selectall" type="checkbox">
                                            {{ __('Select All') }}
                                        </label>
                                    </th>
                                    <th class="w_60">
                                        {{ __('Available permissions') }}
                                    </th>
                                </thead>
                                <tbody>
                                    <!--loop code start -->
                                    @foreach ($custom_permissions as $key => $group)
                                        <tr>
                                            <td class="w_20">
                                                <strong>{{ ucfirst($key) }}</strong>
                                            </td>
                                            <td class="w_20">
                                                <label>
                                                    <input class="selectall form-check-input" type="checkbox">
                                                    {{ __('Select All') }}
                                                </label>
                                            </td>
                                            <td class="w_60">
                                                @forelse($group as $permission)
                                                    <label>
                                                        <input name="permissions[]" class="permissioncheckbox form-check-input"
                                                            type="checkbox" value="{{ $permission->id }}"
                                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                        {{ $permission->name }} &nbsp;&nbsp;
                                                    </label>
                                                @empty
                                                    {{ __('No permission in this group !') }}
                                                @endforelse
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!--loop code end-->
                                </tbody>
                            </table>
                             <!-- table code  end  -->
                        </div>
                        <button type="submit" title=" {{ __('Submit') }}" class="btn btn-primary mt-4"><i class="flaticon-upload-1"></i> {{ __('Submit') }}</button>
                    </div>
                </form>
                <!--form code end -->
            </div>
        </div>
    </div>
@endsection
