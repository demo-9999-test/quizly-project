@extends('admin.layouts.master')
@section('title', 'Testimonials Trash')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['fourthactive' => 'active'])
    @slot('heading')
    {{ __('Testimonials ') }}
    @endslot
    @slot('menu1')
    {{ __('Front panel ') }}
    @endslot
    @slot('menu2')
    {{ __('Testimonials ') }}
    @endslot
    @slot('menu3')
    {{ __('Trash') }}
    @endslot
    @slot('button')
        
<div class="col-md-6 col-lg-6">
    <div class="widget-button">
        <a href="{{ route('testimonial.show') }}" class="btn btn-primary" title=" {{ __('Back') }}"><i class="flaticon-back"></i>
            {{ __('Back') }}</a>
        <a type="button" class="btn btn-danger" data-bs-toggle="modal" title=" {{ __('Delete') }}" data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
    </div>
</div>
@endslot
@endcomponent

<div class="contentbar">
    @include('admin.layouts.flash_msg')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="client-detail-block">
                <div class="table-responsive">
                    <!-- Table start-->
                    <table class="table data-table text-center" id="data-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                <th></th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Client Name') }}</th>
                                <th>{{ __('Ratings') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <!-- loop Print data show Start -->
                        <tbody>
                            @if ($testimonial->isEmpty())
                                <tr>
                                    <td colspan="7">{{ __('No data available') }}</td>
                                </tr>
                            @else
                                @foreach ($testimonial as $data)
                                    <tr>
                                        <td><input type='checkbox' form='bulk_delete_form'
                                                class='check filled-in material-checkbox-input form-check-input' name='checked[]'
                                                value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                        </td>
                                        <td class="py-1">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <img src="{{ asset('/images/testimonial/' . $data->images) }}"
                                                alt="{{ __('testimonial img') }}" class="img-fluid trash-img">
                                        </td>

                                        <td>
                                            {{ $data->client_name }}
                                        </td>
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $data->rating)
                                                    <i class="fas fa-star rating-icon-color"></i>
                                                @else
                                                    <span class="star">&#9734;</span>
                                                @endif
                                            @endfor
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status2" type="checkbox"
                                                    role="switch" id="statusToggle" name="status"
                                                    data-id="{{ $data->id }}" value="{{ $data->status }}"
                                                    {{ $data->status == 1 ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/testimonial/' . $data->id . '/restore') }}"
                                                class="btn btn-primary" title="{{$data->name}}">
                                                <i class="fas fa-trash-restore">Restore</i>
                                            </a>

                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $data->id }}">
                                                <i class="fa fa-trash" aria-hidden="true">Delete</i>
                                            </button>
                                        </td>
                                    </tr>
                                    {{-- -------------model Start ------------------- --}}
                                    <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                        {{ __('Are You Sure ?') }}</h1>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{ __('Do you really want to delete') }} ?
                                                        {{ __('This process cannot be undone.') }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post"
                                                        action="{{ url('admin/testimonial/' . $data->id . '/trash-delete') }}"
                                                        class="pull-right">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="reset" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ __('No') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-primary">{{ __('Yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ------------- model end ------------------------- --}}
                                @endforeach

                                {{-- ------------------------------------- loop  Print data show end------------------------------------------- --}}
                            @endif
                        </tbody>
                        <!-- loop  Print data show end -->
                    </table>
                    <!-- Table end -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>

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

                <form id="bulk_delete_form" method="post" action="{{ route('testimonial.trash_bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="button" class="btn btn-secondary" {{ __('No') }}
                        data-bs-dismiss="modal">{{ __('No') }}</button>
                    <button type="submit" class="btn btn-danger" {{ __('Yes') }}>{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bulk Delete Modal end -->
@endsection
