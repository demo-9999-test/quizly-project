@extends('admin.layouts.master')
@section('title', 'FAQ')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('FAQ') }}
    @endslot
    @slot('menu1')
    {{ __('Front Panel') }}
    @endslot
    @slot('menu2')
    {{ __('FAQ') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        @can('faq.delete')
        <div class="widget-button">
            <a type="button" class="btn btn-danger" data-bs-toggle="modal" title="{{ __('Delete') }}"
                data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
            <a href="{{ route('faq.trash') }}" title="{{ __('Trash') }}" type="button" class="btn btn-success"><i
                    class="flaticon-recycle"></i> {{ __('Trash') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent
    <div class="contentbar  ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <form action="{{ route('faq.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="client-detail-block mb-4">
                        <div class="form-group">
                            <label for="client_name" class="form-label">{{ __('Question') }}<span
                                    class="required">*</span></label>
                            <input class="form-control" type="text" name="question" required id="client_name"
                                placeholder="{{ __('Please Enter Question') }}" aria-label="Heading"
                                value="{{ old('question') }}">
                            <div class="form-control-icon"><i class="flaticon-question-and-answer"></i></div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="desc" class="form-label">{{ __('Answer') }}<span
                                        class="required">*</span></label>
                                <textarea class="form-control form-control-padding_15" name="answer"  rows="4" required
                                    placeholder="{{ __('Please Enter Your Answer') }}"
                                    value="{{ old('answer') }}"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="form-label">{{ __('Status') }}</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status"
                                    value="1" checked>
                            </div>
                        </div>
                        <button type="submit" title="{{ __('Submit') }}" class="btn btn-primary"><i
                                class="flaticon-upload-1"></i> {{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="client-detail-block">
                    <div class="project-main-block">
                        <div class="table-responsive no-btn-table">
                            <table  class="table data-table table-borderless"  id="example">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                        <th>{{ __('Question') }}</th>
                                        <th>{{ __('Answer') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <!-- loop  Print data show Start -->
                                <tbody id="sortable-table">
                                    @if (isset($faq))
                                    @foreach ($faq as $data)
                                    <tr data-id="{{ $data->id }}">
                                        <td><input type='checkbox' form='bulk_delete_form'
                                                class='check filled-in material-checkbox-input form-check-input'
                                                name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                        </td>
                                        <td>
                                            {{ \Illuminate\Support\Str::limit(strip_tags($data->question), $limit = 10, $end = '...') }}
                                        </td>
                                        <td>
                                            {{ \Illuminate\Support\Str::limit(strip_tags($data->answer), $limit = 10, $end = '...') }}
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status8" type="checkbox" role="switch"
                                                    id="statusToggle" name="status" data-id="{{ $data->id }}"
                                                    value="{{ $data->status }}" {{ $data->status == 1 ? 'checked' : ''}}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown action-dropdown">
                                                <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="flaticon-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        @can('faq.edit')
                                                        <a href="{{ url('admin/faq/' . $data->id . '/edit') }}"
                                                            class="dropdown-item" title="{{ __('Edit')}}">
                                                            <i class="flaticon-editing"></i> {{ __('Edit')}}
                                                        </a>
                                                        @endcan
                                                    </li>
                                                    <li>
                                                        @can('faq.create')
                                                        <a href="{{ url('admin/faq/' . $data->id . '/copy') }}"
                                                            class="dropdown-item" title="{{ __('Copy')}}">
                                                            <i class="flaticon-copy"></i> {{ __('Copy')}}
                                                        </a>
                                                        @endcan
                                                    </li>
                                                    <li>
                                                        @can('faq.delete')
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{ $data->id }}"
                                                            title="{{ __('Delete')}}"><i class="flaticon-delete"></i> {{
                                                            __('Delete')}}</a>
                                                        @endcan
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- model Start -->
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
                                                        action="{{ url('admin/faq/' . $data->id . '/delete') }}"
                                                        class="pull-right">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="reset" class="btn btn-secondary"
                                                            title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No')
                                                            }}</button>
                                                        <button type="submit" title="{{ __('Yes') }}"
                                                            class="btn btn-primary">{{ __('Yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- model end -->
                                    @endforeach
                                    <!-- loop  Print data show end -->
                                    @endif
                                </tbody>
                                <!-- loop  Print data show end -->
                            </table>
                            <div class="d-flex justify-content-end">
                                <div class="pagination pagination-circle mb-3">
                                    {{ $faq->onEachSide(1)->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Delete Modal start-->
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
                <form id="bulk_delete_form" method="post" action="{{ route('faq.bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{__('No') }}</button>
                    <button type="submit" class="btn btn-primary" title="{{ __('Yes') }}">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bulk Delete Modal end -->
@endsection

@section('scripts')
<script>
    var baseUrl = "{{ url('/') }}";
</script>
<script src="{{ url('admin_theme/assets/js/faq.js') }}"></script>
@endsection
