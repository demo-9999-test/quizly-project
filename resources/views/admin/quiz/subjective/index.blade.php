@extends('admin.layouts.master')
@section('title', 'Quiz')
@section('main-container')
    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
            @slot('heading')
                {{ __('Add Question') }}
            @endslot
            @slot('menu1')
                {{ __('Add Question') }}
            @endslot
            @slot('button')
                <div class="col-md-6 col-lg-6">
                    <div class="widget-button">
                        @can('subjective.create')
                        <a href="{{ route('subjective.create', ['id' => $quiz->id]) }}" type="button" class="btn btn-primary p-2">
                            <i class="flaticon-plus"></i> {{ __('Add Question') }}</a>
                        @endcan

                        @can('subjective.delete')
                            <a type="button" class="btn btn-danger" title="{{ __('Delete') }}" data-bs-toggle="modal"
                            data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>

                            <a href="{{ route('subjective.trash', ['id' => $quiz->id]) }}" type="button" class="btn btn-success"
                                title=" {{ __('Trash') }}"> <i class="flaticon-recycle"></i>
                                {{ __('Trash') }}</a>
                        @endcan


                        <a href="{{route('subjective.import',['id'=> $quiz->id])}}" type="button" title=" {{ __('Import') }}" class="btn btn-info p-2"> <i class="flaticon-import"></i>{{ __('Import') }}</a>

                        <a href="{{ route('quiz.index') }}" class="btn btn-primary" title="{{ __('Back') }}"><i class="flaticon-back"></i>{{ __('Back') }}</a>
                    </div>
                </div>
            @endslot
        @endcomponent
        <!-- Start Contentbar -->
        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-mcq" role="tabpanel" aria-labelledby="v-pills-mcq-tab" tabindex="0">
                            <div class="client-detail-block" id="mcq-table">
                                <div class="table-responsive">
                                    <!--Table Start -->
                                    <table class="table data-table display nowrap" id="example">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                                <th>{{ __('#') }}</th>
                                                <th>{{ __('Image') }}</th>
                                                <th>{{ __('Question') }}</th>
                                                <th>{{ __('Video Link') }}</th>
                                                <th>{{__('Audo Link')}}</th>
                                                <th>{{ __('Mark') }}</th>
                                                <th>{{ __('Subject') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <!-- loop  Print data show Start --->
                                        <tbody>
                                            @php
                                                $counter = 1;
                                            @endphp
                                            @foreach ($sub as $data)
                                            @php
                                                 $subject_id = $data->quiz_id;
                                            @endphp
                                            @if(($subject_id == $quiz->id))
                                            <tr>
                                                <td><input type="checkbox" form="bulk_delete_form" class="check filled-in material-checkbox-input form-check-input" name="checked[]" value="{{ $data->id }}" id="checkbox{{ $data->id }}"></td>
                                                <td>{{ $counter++ }}</td>
                                                <td>
                                                @if (!empty($data->image))
                                                    <img src="{{ asset('/images/quiz/subjective/' . $data->image) }}" alt=" {{ __('user img') }}" class="widget-img">
                                                    @else
                                                    <img src="{{ Avatar::create($data->question)->toBase64() }}" />
                                                @endif
                                                </td>
                                                <td width=10%>{{ $data->question }}</td>
                                                <td>{{ $data->video }}</td>
                                                <td>{{ $data->audio }}</td>
                                                <td>{{ $data->mark }}</td>
                                                <td>{{ $quiz->subject }}</td>
                                                <td>
                                                    <div class="dropdown action-dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="flaticon-dots"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                @can('subjective.edit')
                                                                <a href="{{ route('subjective.edit', ['id' => $quiz->id, 'sub_id' => $data->id]) }}" class="dropdown-item" title="{{ __('Edit') }}">
                                                                    <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                                 </a>
                                                                @endcan
                                                            </li>
                                                            <li>
                                                                @can('subjective.delete')
                                                                <a class="dropdown-item" href="#" title="{{ __('Delete') }}" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $data->id }}">
                                                                    <i class="flaticon-delete"></i> {{ __('Delete') }}
                                                                </a>
                                                                @endcan
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" aria-labelledby="deleteModal{{ $data->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModal{{ $data->id }}">{{ __('Confirm Delete') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('Are you sure you want to delete this quiz?') }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <form id="deleteFormTrueFalse{{ $data->id }}" action="{{ route('subjective.delete', ['id' => $quiz->id, 'obj_id' => $data->id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!--Table End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contentbar -->
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No') }}</button>
                    <form id="bulk_delete_form" method="post" action="{{ route('subjective.bulk_delete',['id'=>$quiz->id]) }}">
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

