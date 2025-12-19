@extends('admin.layouts.master')
@section('title', 'Users Account Delete Request')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['secondaryactive' => 'active'])
        @slot('heading')
        {{ __('Users Account Delete Request') }}
        @endslot
        @slot('menu1')
        {{ __('Users Account Delete Request') }}
        @endslot
    @endcomponent
    
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block user-page">
                    <div class="table-responsive">
                        <!-- Table start-->
                        <table class="table display" id="example">
                            <thead>
                                <tr>
                                    <th>{{ __('Username') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Reason') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Requested At') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    <tr>
                                        <td>
                                            @if ($request->user)
                                                {{ $request->user->name }}
                                            @else
                                                {{ __('User not found') }}
                                            @endif
                                        </td>
                                        <td>{{ $request->user ? $request->user->email : __('N/A') }}</td>
                                        <td>
                                            @if ($request->reasonDetail)
                                                {{ $request->reasonDetail->reason }}
                                            @else
                                                {{ $request->reason }}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'danger') }}">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $request->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if ($request->status === 'pending')
                                                <button type="button" class="btn btn-sm btn-success approve-btn" data-id="{{ $request->id }}">
                                                    {{ __('Approve') }}
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger reject-btn" data-id="{{ $request->id }}">
                                                    {{ __('Reject') }}
                                                </button>
                                            @else
                                                {{ __('No actions available') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Table end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('admin_theme/assets/js/user-delete-requests.js') }}"></script>
<script>
    const approveRoute = `{{ route('user_delete.approve', ':id') }}`;
    const rejectRoute = `{{ route('user_delete.reject', ':id') }}`;
</script>
@endsection
