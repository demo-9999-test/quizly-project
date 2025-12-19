@extends('admin.layouts.master')
@section('title', 'Trusted Slider')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Trusted Slider') }}
    @endslot
    @slot('menu1')
    {{ __('Trusted Slider') }}
    @endslot
    @slot('button')
    <div class="col-md-6 col-lg-6">
        @can('trustedslider.view')
        <div class="widget-button">
            <a href="{{ route('trusted.slider.create') }}" type="button" class="btn btn-primary" title="{{ __('Add') }}"><i class="flaticon-plus"></i> {{ __('Add') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent

    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block">
                    <div class="table-responsive ">
                        <!-- Table start -->
                        <table  class="table data-table table-borderless"  id="example">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('URL') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <!-- Loop Print Data Show Start -->
                            <tbody id="sortable-table">
                                @foreach ($trustedsliders as $data)
                                <tr data-id="{{ $data->id }}">
                                    <td>
                                        <input type="checkbox" form="bulk_delete_form"
                                        class="check filled-in material-checkbox-input form-check-input"
                                        name="checked[]" value="{{ $data->id }}" id="checkbox{{ $data->id }}">
                                    </td>

                                    <td>
                                        @if (!empty($data->image))
                                        <img src="{{ asset('/images/trusted-slider/' . $data->image) }}"
                                             style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                             onclick="openImageModal('{{ asset('/images/trusted-slider/' . $data->image) }}')">
                                        @else
                                        <img src="{{ Avatar::create($data->name)->toBase64() }}" />
                                        @endif
                                    </td>
                                    <td>{{ $data->url }}</td>
                                    <td>
                                        @if ($data->status == 1)
                                        <span class="badge bg-success"> {{ __('Active') }} </span>
                                        @else
                                        <span class="badge bg-danger"> {{ __('InActive') }} </span>
                                        @endif
                                    </td>
                                    <td>{{ $data->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="dropdown action-dropdown">
                                            <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="flaticon-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    @can('trustedslider.edit')
                                                    <a href="{{ url('admin/trusted/slider/' . $data->id . '/edit') }}"
                                                        class="dropdown-item" title="{{ __('Edit')}}">
                                                        <i class="flaticon-editing"></i> {{ __('Edit')}}
                                                    </a>
                                                    @endcan
                                                </li>
                                                <li>
                                                    @can('trustedslider.delete')
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $data->id }}"
                                                        title="{{ __('Delete')}}"><i class="flaticon-delete"></i> {{__('Delete')}}</a>
                                                    @endcan
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
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
                                                    action="{{ url('admin/trusted/slider/' . $data->id . '/delete') }}"
                                                    class="pull-right">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">{{ __('No') }}</button>
                                                    <button type="submit" class="btn btn-primary">{{ __('Yes')
                                                        }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                            <!-- Loop Print Data Show End -->
                        </table>
                        <!-- Table end -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                <form id="bulk_delete_form" method="post" action="">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var baseUrl = "{{ url('/') }}";
</script>
<script src="{{ url('admin_theme/assets/js/trustedslider.js') }}"></script>
@endsection
