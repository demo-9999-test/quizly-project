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
                        @can('objective.create')
                            <a href="{{ route('objective.create',['id'=>$quiz->id])}}" type="button" class="btn btn-primary p-2">
                            <i class="flaticon-plus"></i>  {{ __('Add Question') }}</a>
                        @endcan
                        @can('objective.delete')
                            <a type="button" class="btn btn-danger" title="{{ __('Delete') }}" data-bs-toggle="modal"
                            data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>

                            <a href="{{route('objective.trash',['id'=>$quiz->id])}}" type="button" class="btn btn-success"
                             title=" {{ __('Trash') }}"> <i class="flaticon-recycle"></i>
                            {{ __('Trash') }}</a>
                        @endcan
                        <a href="{{route('objective.import', ['id'=>$quiz->id])}}" type="button" title=" {{ __('Import') }}" class="btn btn-info p-2"> <i class="flaticon-import"></i>{{ __('Import') }}</a>

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

                <!-- Start Tab-button Code -->
                    <div class="quiz-tab">
                        <div class="nav nav-pills nav-tabs" id="v-pills-tab" role="tablist">
                            <a class="nav-link active" id="v-pills-mcq-tab" data-bs-toggle="pill"
                            href="#v-pills-mcq" type="button" role="tab" aria-controls="v-pills-mcq" aria-selected="true">
                                {{ __('Multiple Choice') }}
                            </a>
                            <a class="nav-link" id="v-pills-true_false-tab" data-bs-toggle="pill"
                            href="#v-pills-true_false" type="button" role="tab" aria-controls="v-pills-true_false"
                                aria-selected="false">
                                {{ __('True And False') }}
                            </a>
                            <a class="nav-link" id="v-pills-fill_blanks-tab" data-bs-toggle="pill"
                            href="#v-pills-fill_blanks" type="button" role="tab" aria-controls="v-pills-fill_blanks"
                                aria-selected="false">
                                {{ __('Fill in the blanks') }}
                            </a>
                            <a class="nav-link" id="v-pills-match_following-tab" data-bs-toggle="pill"
                                href="#v-pills-match_following" type="button" role="tab" aria-controls="v-pills-match_following"
                                aria-selected="false">
                                {{ __('Match The Following') }}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Tab-button Code -->

                <div class="col-lg-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-mcq" role="tabpanel"
                            aria-labelledby="v-pills-mcq-tab" tabindex="0">
                            <div class="client-detail-block" id="mcq-table">
                                <div class="table-responsive">
                                    <!--Table-mcq Start -->
                                    <table class="table data-table display nowrap" id="questionTable">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                                <th>{{ __('#') }}</th>
                                                <th>{{__('Image')}}</th>
                                                <th>{{ __('Question') }}</th>
                                                <th>{{ __('Option A') }}</th>
                                                <th>{{ __('Option B') }}</th>
                                                <th>{{ __('Option C') }}</th>
                                                <th>{{ __('Option D') }}</th>
                                                <th>{{ __('Correct Option') }}</th>
                                                <th>{{__('Video')}}</th>
                                                <th>{{__('Audio')}}</th>
                                                <th>{{__('Mark')}}</th>
                                                <th>{{ __('Subject') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>

                                        <!-- loop  Print data show Start --->
                                        <tbody>
                                            @php
                                                $counter = 1;
                                            @endphp
                                            @foreach ($obj as $objItem)
                                            @php
                                                $type = $objItem->ques_type;
                                                $subject_id = $objItem->quiz_id;
                                            @endphp
                                            @if (($subject_id == $quiz->id) && ($type == 'multiple_choice'))
                                            <tr>
                                                <td><input type="checkbox" form="bulk_delete_form" class="check filled-in material-checkbox-input form-check-input" name="checked[]" value="{{ $objItem->id }}" id="checkbox{{ $objItem->id }}"></td>
                                                <td>{{ $counter++ }}</td>
                                                <td>
                                                    @if (!empty($objItem->image))
                                                    <img src="{{ asset('/images/quiz/objective/multiple_choice/' . $objItem->image) }}" alt=" {{ __('user img') }}" class="widget-img">
                                                    @else
                                                    <img src="{{ Avatar::create($objItem->question)->toBase64() }}" />
                                                    @endif
                                                </td>
                                                <td>{{ $objItem->question }}</td>
                                                <td>{{ $objItem->option_a }}</td>
                                                <td>{{ $objItem->option_b }}</td>
                                                <td>{{ $objItem->option_c }}</td>
                                                <td>{{ $objItem->option_d }}</td>
                                                <td>{{ $objItem->correct_answer }}</td>
                                                <td>{{ $objItem->audio }}</td>
                                                <td>{{ $objItem->video }}</td>
                                                <td>{{ $objItem->mark }}</td>
                                                <td>{{ $quiz->subject}}</td>
                                                <td>
                                                    <div class="dropdown action-dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="flaticon-dots"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                @can('objective.edit')
                                                                    <a href="{{ route('objective.edit',['id'=>$quiz->id ,'obj_id' => $objItem->id]) }}"
                                                                        class="dropdown-item" title="{{ __('Edit')}}">
                                                                        <i class="flaticon-editing"></i> {{ __('Edit')}}
                                                                    </a>
                                                                @endcan
                                                            </li>
                                                            <li>
                                                                @can('objective.delete')
                                                                    <a class="dropdown-item" href="#" title="{{ __('Delete')}}" data-bs-toggle="modal" data-bs-target="#deleteModal_mcq_{{ $objItem->id }}">
                                                                        <i class="flaticon-delete"></i> {{ __('Delete')}}
                                                                    </a>
                                                                @endcan
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </td>
                                            </tr>
                                            {{-- -------------model Start ------------------- --}}
                                            <div class="modal fade" id="deleteModal_mcq_{{ $objItem->id }}" tabindex="-1" aria-labelledby="deleteModalLabel_mcq_{{ $objItem->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel_mcq_{{ $objItem->id }}">{{ __('Confirm Delete') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('Are you sure you want to delete this quiz?') }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <form id="deleteForm_mcq_{{ $objItem->id }}" action="{{ route('objective.delete', ['id' => $quiz->id, 'obj_id' => $objItem->id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- ------------- model end ------------------------- --}}
                                            @endif
                                            @endforeach
                                            <!---- loop  Print data show end----------------------------->
                                        </tbody>
                                    </table>
                                    <!--Table-mcq End -->
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-true_false" role="tabpanel"
                            aria-labelledby="v-pills-true_false-tab" tabindex="1">
                            <div class="client-detail-block" id="truefalse-table">
                                <div class="table-responsive">
                                    <!-- Table True/False Start -->
                                    <table class="table data-table display nowrap" id="questionTable">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                                <th>{{ __('#') }}</th>
                                                <th>{{ __('Image')}}</th>
                                                <th>{{ __('Question') }}</th>
                                                <th>{{ __('Option 1') }}</th>
                                                <th>{{ __('Option 2') }}</th>
                                                <th>{{ __('Correct Option') }}</th>
                                                <th>{{ __('Audio')}}</th>
                                                <th>{{ __('Video')}}</th>
                                                <th>{{__('Mark')}}</th>
                                                <th>{{ __('Subject') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <!-- loop  Print data show Start --->
                                        <tbody>
                                            @php
                                                $counter = 1
                                            @endphp
                                            @foreach ($obj as $objItem)
                                            @php
                                                $question = $objItem->ques_type;
                                                $subject_id = $objItem->quiz_id;
                                            @endphp
                                            @if (($subject_id == $quiz->id) && ($question == 'true_false'))
                                            <tr>
                                                <td><input type="checkbox" form="bulk_delete_form" class="check filled-in material-checkbox-input form-check-input" name="checked[]" value="{{ $objItem->id }}" id="checkbox{{ $objItem->id }}"></td>
                                                <td>{{ $counter++ }}</td>
                                                <td>
                                                    @if (!empty($objItem->image))
                                                    <img src="{{ asset('/images/quiz/objective/true_false/' . $objItem->image) }}" alt=" {{ __('user img') }}" class="widget-img">
                                                    @else
                                                    <img src="{{ Avatar::create($objItem->question)->toBase64() }}" />
                                                    @endif
                                                </td>
                                                <td>{{ $objItem->question }}</td>
                                                <td>{{ $objItem->option_a }}</td>
                                                <td>{{ $objItem->option_b }}</td>
                                                <td>{{ $objItem->correct_answer }}</td>
                                                <td>{{ $objItem->audio }}</td>
                                                <td>{{ $objItem->video }}</td>
                                                <td>{{ $objItem->mark }}</td>
                                                <td>{{ $quiz->subject}}</td>
                                                <td>
                                                    <div class="dropdown action-dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="flaticon-dots"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                @can('objective.edit')
                                                                <a href="{{ route('objective.edit', ['id' => $quiz->id, 'obj_id' => $objItem->id]) }}"
                                                                    class="dropdown-item" title="{{ __('Edit') }}">
                                                                    <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                                 </a>
                                                                 @endcan
                                                            </li>
                                                            <li>
                                                                @can('objective.delete')
                                                                    <a class="dropdown-item" href="#" title="{{ __('Delete')}}" data-bs-toggle="modal" data-bs-target="#deleteModalTrueFalse{{ $objItem->id }}">
                                                                        <i class="flaticon-delete"></i> {{ __('Delete')}}
                                                                    </a>
                                                                @endcan
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            {{-- -------------model Start ------------------- --}}
                                            <div class="modal fade" id="deleteModalTrueFalse{{ $objItem->id }}" tabindex="-1" aria-labelledby="deleteModalLabelTrueFalse{{ $objItem->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabelTrueFalse{{ $objItem->id }}">{{ __('Confirm Delete') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('Are you sure you want to delete this quiz?') }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <form id="deleteFormTrueFalse{{ $objItem->id }}" action="{{ route('objective.delete', ['id' => $quiz->id, 'obj_id' => $objItem->id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- ------------- model end ------------------------- --}}
                                            @endif
                                            @endforeach
                                        <!---- loop  Print data show end----------------------------->
                                        </tbody>
                                    </table>
                                    <!-- Table True/False End -->
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-fill_blanks" role="tabpanel"
                            aria-labelledby="v-pills-fill_blanks-tab" tabindex="2">
                            <div class="client-detail-block" id="fillBlank-table">
                            <!-- Table Fill Blanks Start -->
                                <div class="table-responsive">
                                    <table class="table data-table display nowrap" id="questionTable">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                                <th>{{ __('#') }}</th>
                                                <th>{{ __('Image')}}</th>
                                                <th>{{ __('Question') }}</th>
                                                <th>{{ __('Correct Answer') }}</th>
                                                <th>{{ __('Audio')}}</th>
                                                <th>{{ __('Video')}}</th>
                                                <th>{{__('Mark')}}</th>
                                                <th>{{ __('Subject') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <!-- loop  Print data show Start --->
                                        <tbody>
                                            @php
                                                $counter = 1
                                            @endphp
                                            @foreach ($obj as $objItem)
                                            @php
                                                $question = $objItem->ques_type;
                                                $subject_id = $objItem->quiz_id;
                                            @endphp
                                            @if (($subject_id == $quiz->id) && ($question == 'fill_blank'))
                                            <tr>
                                                <td><input type="checkbox" form="bulk_delete_form" class="check filled-in material-checkbox-input form-check-input" name="checked[]" value="{{ $objItem->id }}" id="checkbox{{ $objItem->id }}"></td>
                                                <td>{{ $counter++ }}</td>
                                                <td>
                                                    @if (!empty($objItem->image))
                                                    <img src="{{ asset('/images/quiz/objective/fill_blank/' . $objItem->image) }}" alt=" {{ __('user img') }}" class="widget-img">
                                                    @else
                                                    <img src="{{ Avatar::create($objItem->question)->toBase64() }}" />
                                                    @endif
                                                </td>
                                                <td>{{ $objItem->question }}</td>
                                                <td>{{ $objItem->correct_answer }}</td>
                                                <td>{{ $objItem->audio }}</td>
                                                <td>{{ $objItem->video }}</td>
                                                <td>{{ $objItem->mark }}</td>
                                                <td>{{ $quiz->subject}}</td>
                                                <td>
                                                    <div class="dropdown action-dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="flaticon-dots"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                @can('objective.edit')
                                                                <a href="{{ route('objective.edit', ['id' => $quiz->id, 'obj_id' => $objItem->id]) }}"
                                                                    class="dropdown-item" title="{{ __('Edit') }}">
                                                                    <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                                </a>
                                                                @endcan
                                                            </li>
                                                            <li>
                                                                @can('objective.delete')
                                                                    <a class="dropdown-item" href="#" title="{{ __('Delete')}}" data-bs-toggle="modal" data-bs-target="#deleteModalTrueFalse{{ $objItem->id }}">
                                                                        <i class="flaticon-delete"></i> {{ __('Delete')}}
                                                                    </a>
                                                                @endcan
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                            {{-- -------------model Start ------------------- --}}
                                            <div class="modal fade" id="deleteModalTrueFalse{{ $objItem->id }}" tabindex="-1" aria-labelledby="deleteModalLabelTrueFalse{{ $objItem->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabelTrueFalse{{ $objItem->id }}">{{ __('Confirm Delete') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('Are you sure you want to delete this quiz?') }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <form id="deleteFormTrueFalse{{ $objItem->id }}" action="{{ route('objective.delete', ['id' => $quiz->id, 'obj_id' => $objItem->id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- ------------- model end ------------------------- --}}
                                            @endforeach
                                        <!---- loop  Print data show end----------------------------->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Table Fill Blanks End -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-match_following" role="tabpanel"
                            aria-labelledby="v-pills-fill_blanks-tab" tabindex="3">
                            <div class="client-detail-block" id="matchFollowing-table">
                                <!-- Table Match Following Start -->
                                <div class="table-responsive">
                                    <table class="table data-table display nowrap" id="questionTable">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                                <th>{{ __('#') }}</th>
                                                <th>{{ __('Image')}}</th>
                                                <th>{{ __('Column A') }}</th>
                                                <th>{{ __('Column B') }}</th>
                                                <th>{{ __('Correct Answer') }}</th>
                                                <th>{{ __('Audio')}}</th>
                                                <th>{{ __('Video')}}</th>
                                                <th>{{ __('Mark') }}</th>
                                                <th>{{ __('Subject') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $counter = 1;
                                            @endphp
                                            @foreach ($obj as $objItem)
                                                @php
                                                $question = $objItem->ques_type;
                                                $subject_id = $objItem->quiz_id;
                                                @endphp
                                            @if (($subject_id == $quiz->id) && ($question == 'match_following'))
                                                <tr>
                                                    <td><input type="checkbox" form="bulk_delete_form" class="check filled-in material-checkbox-input form-check-input" name="checked[]" value="{{ $objItem->id }}" id="checkbox{{ $objItem->id }}"></td>
                                                    <td>{{ $counter++ }}</td>
                                                    <td>
                                                        @if (!empty($objItem->image))
                                                            <img src="{{ asset('/images/quiz/objective/match_following/' . $objItem->image) }}" alt="{{ __('user img') }}" class="widget-img">
                                                        @else
                                                            <img src="{{ Avatar::create($objItem->question)->toBase64() }}" />
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <ul>
                                                            @foreach($objItem->option_a as $index => $option)
                                                                <li>{{ chr(65 + $index) }}. {{ $option }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <ul>
                                                            @foreach($objItem->option_b as $index => $option)
                                                                <li>{{ $index + 1 }}. {{ $option }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <ul>
                                                            @foreach($objItem->correct_answer as $index => $option)
                                                                <li>{{ $index + 1 }}. {{ $option }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>{{ $objItem->audio }}</td>
                                                    <td>{{ $objItem->video }}</td>
                                                    <td>{{ $objItem->mark }}</td>
                                                    <td>{{ $quiz->subject}}</td>
                                                    <td>
                                                        <div class="dropdown action-dropdown">
                                                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="flaticon-dots"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                @can('objective.edit')
                                                                    <li>
                                                                        <a href="{{ route('objective.edit', ['id' => $quiz->id, 'obj_id' => $objItem->id]) }}" class="dropdown-item" title="{{ __('Edit') }}">
                                                                            <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                                        </a>
                                                                    </li>
                                                                @endcan
                                                                @can('objective.delete')
                                                                    <li>
                                                                        <a class="dropdown-item" href="#" title="{{ __('Delete')}}" data-bs-toggle="modal" data-bs-target="#deleteModalLabelMatchFollowing{{ $objItem->id }}">
                                                                            <i class="flaticon-delete"></i> {{ __('Delete')}}
                                                                        </a>
                                                                    </li>
                                                                @endcan
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                {{-- Modal --}}
                                            @endif
                                            {{-- -------------model Start ------------------- --}}
                                            <div class="modal fade" id="deleteModalLabelMatchFollowing{{ $objItem->id }}" tabindex="-1" aria-labelledby="deleteModalLabelMatchFollowing{{ $objItem->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabelTrueFalse{{ $objItem->id }}">{{ __('Confirm Delete') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('Are you sure you want to delete this quiz?') }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <form id="deleteFormTrueFalse{{ $objItem->id }}" action="{{ route('objective.delete', ['id' => $quiz->id, 'obj_id' => $objItem->id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- ------------- model end ------------------------- --}}
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Table Match Following End -->
                            </div>
                            <!-- Table  End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contentbar -->
    </div>

    <!-- Start Bulk Delete Modal -->
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
                    <form id="bulk_delete_form" method="post" action="{{ route('objective.bulk_delete',['id'=>$quiz->id]) }}">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bulk Delete Modal -->
@endsection
