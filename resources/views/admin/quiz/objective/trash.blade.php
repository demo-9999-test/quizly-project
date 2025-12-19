@extends('admin.layouts.master')
@section('title', 'Quiz')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Quiz ') }}
    @endslot
    @slot('menu1')
    {{ __('Quiz ') }}
    @endslot
    @slot('menu2')
    {{ __('Trash ') }}
    @endslot

    @slot('button')
    <div class="col-md-6 col-lg-6">
        <div class="widget-button">
            <a href="{{ route('objective.index',['id'=>$quiz->id]) }}" class="btn btn-primary" title="{{ __('Back') }}"><i class="flaticon-back"></i>
                {{ __('Back') }}</a>
            <a type="button" class="btn btn-danger " title="{{ __('Delete') }}" data-bs-toggle="modal"
                data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
        </div>
    </div>
    @endslot
    @endcomponent

    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <!-- Start Tab-button Code -->
                    <div class="quiz-tab">
                        <div class="nav nav-pills table-tabs" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
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
                    <!-- Start Tab-button Code -->
                </div>
                <div class="col-lg-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-mcq" role="tabpanel"
                            aria-labelledby="v-pills-mcq-tab" tabindex="0">
                            <div class="client-detail-block">
                                <div class="table-responsive">
                                    <!--- Table start-->
                                    <table class="table data-table display nowrap" id="example">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                                <th></th>
                                                <th>{{ __('Question') }}</th>
                                                <th>{{ __('Options') }}</th>
                                                <th>{{ __('Correct Answer') }}</th>
                                                <th>{{__('Subject')}}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $counter = 1;
                                            @endphp
                                        @foreach ($obj as $data )
                                        @php
                                        $type = $data->ques_type;
                                        $subject_id = $data->quiz_id;
                                        @endphp
                                        @if (($subject_id == $quiz->id) && ($type == 'multiple_choice'))
                                            <tr>
                                                <td>
                                                    <input type='checkbox' form='bulk_delete_form'
                                                        class='check filled-in material-checkbox-input form-check-input'
                                                        name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                                </td>
                                                <td class="py-1">
                                                    {{ $counter++ }}
                                                </td>
                                                <td>
                                                    {{ $data->question }}
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li><strong>{{ __('Option A:') }}</strong> {{ $data->option_a }}</li>
                                                        <li><strong>{{ __('Option B:') }}</strong> {{ $data->option_b }} </li>
                                                        <li><strong>{{ __('Option C:') }}</strong> {{ $data->option_c }} </li>
                                                        <li><strong>{{ __('Option D:') }}</strong> {{ $data->option_d }} </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    {{ $data->correct_answer }}
                                                </td>
                                                <td>
                                                    {{$quiz->subject}}
                                                </td>
                                                <td>
                                                    <div class="dropdown action-dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="flaticon-dots"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ url('admin/objective/' . $quiz->id .'/' . $data->id . '/restore') }}"
                                                                    class="dropdown-item" title="{{ __('Restore')}}">
                                                                    <i class="flaticon-restore"></i> Restore
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $data->id }}" title="{{ __('Delete')}}"><i class="flaticon-delete"></i>Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
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
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('Do you really want to delete') }} ?
                                                                {{ __('This process cannot be undone.') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="post"
                                                                action="{{ url('admin/objective/' . $quiz->id . '/'. $data->id . '/trash-delete') }}"
                                                                class="pull-right">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="reset" class="btn btn-secondary"
                                                                    title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No')
                                                                    }}</button>
                                                                <button type="submit" class="btn btn-primary" title="{{ __('Yes')
                                                            }}">{{ __('Yes')
                                                                    }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- ------------- model end ------------------------- --}}
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Table end--->
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-true_false" role="tabpanel"
                            aria-labelledby="v-pills-true_false-tab" tabindex="0">
                            <div class="client-detail-block">
                                <div class="table-responsive">

                                    <!--- Table start-->
                                    <table class="table data-table display nowrap" id="example">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                                <th></th>
                                                <th>{{ __('Question') }}</th>
                                                <th>{{ __('Option') }}</th>
                                                <th>{{ __('Correct Answer') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($obj as $data )
                                            @php
                                                $type = $data->ques_type;
                                                $subject_id = $data->quiz_id;
                                               @endphp
                                            @if (($subject_id == $quiz->id) && ($type == 'true_false'))
                                            <tr>
                                                <td>
                                                    <input type='checkbox' form='bulk_delete_form'
                                                        class='check filled-in material-checkbox-input form-check-input'
                                                        name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                                </td>
                                                <td class="py-1">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $data->question }}
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li><strong>{{ __('Option A:') }}</strong> {{ $data->option_a }}</li>
                                                        <li><strong>{{ __('Option B:') }}</strong> {{ $data->option_b }} </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    {{ $data->correct_answer }}
                                                </td>
                                                <td>
                                                    <div class="dropdown action-dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="flaticon-dots"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ url('admin/objective/' . $quiz->id .'/' . $data->id . '/restore') }}"
                                                                    class="dropdown-item" title="{{ __('Restore')}}">
                                                                    <i class="flaticon-editing"></i> Restore
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal{{ $data->id }}"
                                                                    title="{{ __('Delete')}}"><i class="flaticon-delete"></i>Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
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
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('Do you really want to delete') }} ?
                                                                {{ __('This process cannot be undone.') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="post"
                                                                action="{{ url('admin/objective/' . $quiz->id . '/'. $data->id . '/trash-delete') }}"
                                                                class="pull-right">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="reset" class="btn btn-secondary"
                                                                    title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No')
                                                                    }}</button>
                                                                <button type="submit" class="btn btn-primary" title="{{ __('Yes')
                                                            }}">{{ __('Yes')
                                                                    }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- ------------- model end ------------------------- --}}
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Table end--->
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-fill_blanks" role="tabpanel"
                            aria-labelledby="v-pills-fill_blanks-tab" tabindex="2">
                            <div class="client-detail-block" id="fillBlank-table">
                                <div class="table-responsive">
                                    <!--- Table start-->
                                    <table class="table data-table display nowrap" id="example">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                                <th></th>
                                                <th>{{ __('Question') }}</th>
                                                <th>{{ __('Correct Answer') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $counter = 1;
                                            @endphp
                                            @foreach ($obj as $data )
                                            @php
                                            $type = $data->ques_type;
                                            $subject_id = $data->quiz_id;
                                            @endphp
                                            @if (($subject_id == $quiz->id) && ($type == 'fill_blank'))
                                            <tr>
                                                <td>
                                                    <input type='checkbox' form='bulk_delete_form'
                                                        class='check filled-in material-checkbox-input form-check-input'
                                                        name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                                </td>
                                                <td class="py-1">
                                                    {{ $counter++ }}
                                                </td>
                                                <td>
                                                    {{ $data->question }}
                                                </td>
                                                <td>
                                                    {{ $data->correct_answer }}
                                                </td>
                                                <td>
                                                    <div class="dropdown action-dropdown">
                                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="flaticon-dots"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ url('admin/objective/' . $quiz->id .'/' . $data->id . '/restore') }}"
                                                                    class="dropdown-item" title="{{ __('Restore')}}">
                                                                    <i class="flaticon-editing"></i> Restore
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal{{ $data->id }}"
                                                                    title="{{ __('Delete')}}"><i class="flaticon-delete"></i>Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
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
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('Do you really want to delete') }} ?
                                                                {{ __('This process cannot be undone.') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="post"
                                                                action="{{ url('admin/objective/' . $quiz->id . '/'. $data->id . '/trash-delete') }}"
                                                                class="pull-right">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="reset" class="btn btn-secondary"
                                                                    title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No')
                                                                    }}</button>
                                                                <button type="submit" class="btn btn-primary" title="{{ __('Yes')
                                                            }}">{{ __('Yes')
                                                                    }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- ------------- model end ------------------------- --}}
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Table end--->
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-match_following" role="tabpanel"
                            aria-labelledby="v-pills-fill_blanks-tab" tabindex="3">
                            <div class="table-responsive">
                                <!--- Table start-->
                                <table class="table data-table display nowrap" id="example">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                            <th></th>
                                            <th>{{ __('Question') }}</th>
                                            <th>{{ __('Column A') }}</th>
                                            <th>{{ __('Column B') }}</th>
                                            <th>{{ __('Correct Answer') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @foreach ($obj as $data )
                                        @php
                                        $type = $data->ques_type;
                                        $subject_id = $data->quiz_id;
                                        @endphp
                                        @if (($subject_id == $quiz->id) && ($type == 'match_following'))
                                        <tr>
                                            <td>
                                                <input type='checkbox' form='bulk_delete_form'
                                                    class='check filled-in material-checkbox-input form-check-input'
                                                    name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                            </td>
                                            <td class="py-1">
                                                {{ $counter++ }}
                                            </td>
                                            <td>
                                                {{ $data->question }}
                                            </td>
                                            <td>
                                                <ul>
                                                    @if(is_array($data->option_a))
                                                        @foreach($data->option_a as $index => $option)
                                                            <li>{{ chr(65 + $index) }}. {{ $option }}</li>
                                                        @endforeach
                                                    @else
                                                        <li>{{ $data->option_a }}</li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    @if(is_array($data->option_b))
                                                        @foreach($data->option_b as $index => $option)
                                                            <li>{{ chr(65 + $index) }}. {{ $option }}</li>
                                                        @endforeach
                                                    @else
                                                        <li>{{ $data->option_b }}</li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    @if(is_array($data->correct_answer))
                                                        @foreach($data->correct_answer as $index => $option)
                                                            <li>{{ chr(65 + $index) }}. {{ $option }}</li>
                                                        @endforeach
                                                    @else
                                                        <li>{{ $data->correct_answer }}</li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="dropdown action-dropdown">
                                                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="flaticon-dots"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="{{ url('admin/objective/' . $quiz->id .'/' . $data->id . '/restore') }}"
                                                                class="dropdown-item" title="{{ __('Restore')}}">
                                                                <i class="flaticon-editing"></i> Restore
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal{{ $data->id }}"
                                                                title="{{ __('Delete')}}"><i class="flaticon-delete"></i>Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
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
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ __('Do you really want to delete') }} ?
                                                            {{ __('This process cannot be undone.') }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post"
                                                            action="{{ url('admin/objective/' . $quiz->id . '/'. $data->id . '/trash-delete') }}"
                                                            class="pull-right">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button type="reset" class="btn btn-secondary"
                                                                title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No')}}</button>
                                                            <button type="submit" class="btn btn-primary" title="{{ __('Yes')}}">{{ __('Yes')}}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- ------------- model end ------------------------- --}}
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- Table end--->
                            </div>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('No') }}</button>
                    <form id="bulk_delete_form" method="post" action="{{route('objective.trash_bulk_delete',['id'=>$quiz->id])}}">
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
