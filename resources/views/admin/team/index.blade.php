@extends('admin.layouts.master')
@section('title', 'Team Member')
@section('main-container')
<div class="dashboard-card">
    @component('admin.components.breadcumb',['secondaryactive' => 'active'])
        @slot('heading')
        {{ __('Team Member') }}
        @endslot
        @slot('menu1')
        {{ __('Team Member') }}
        @endslot
        @slot('button')
        <div class="col-md-6 col-lg-6">
            <div class="widget-button">
                @can('team.create')
                <a href="{{ route('members.create') }}" type="button" class="btn btn-primary"
                    title="{{ __('Add') }}"><i class="flaticon-plus"></i> {{ __('Add') }}</a>
                @endcan

                @can('team.delete')
                <a type="button" class="btn btn-danger" title="{{ __('Delete') }}" data-bs-toggle="modal"
                    data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
                @endcan
            </div>
        </div>
        @endslot
        @endcomponent
    <!-- Breadcrumb Start -->

    <!-- Breadcrumb End -->
     <div class="contentbar">
        @include('admin.layouts.flash_msg');
            <!-- Start row -->
            <div class="client-detail-block">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            {{-- table code start --}}
                            <table  class="table data-table table-borderless"  id="example">
                                <thead>
                                    <tr>
                                        <th>
                                            <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                                value="all" />
                                            <label for="checkboxAll" class="material-checkbox"></label>
                                        </th>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Designation') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-table">
                                    @if ($team)
                                    <?php $i=0;?>
                                        @foreach ($team as $data)
                                        <?php $i++;?>
                                            <tr data-id="{{ $data->id }}">
                                            <td>
                                                <input type='checkbox' form='bulk_delete_form'
                                                    class='check filled-in material-checkbox-input' name='checked[]'
                                                    value="{{ $data->id }}" id='checkbox{{ $data->id }}'>
                                                <label for='checkbox{{ $data->id }}' class='material-checkbox'></label>
                                            </td>

                                                <td>
                                                    <?php echo $i;?></td>
                                                <td>
                                                    @if (!empty($data->image))
                                                    <img src="{{ asset('/images/team/' . $data->image) }}"
                                                        alt="{{ __('img') }}" class="widget-img" alt="{{ $data->title }}">
                                                    @else
                                                    <img src="{{ Avatar::create($data->title)->toBase64() }}" alt="{{ $data->title }}">
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $data->name }}
                                                </td>

                                                <td>
                                                    {{ $data->designation }}
                                                </td>

                                                <td>
                                                    @if ($data->status == 1)
                                                    <div class="badge text-bg-success">{{__('Active')}}</div>
                                                    @else
                                                    <div class="badge text-bg-danger">{{__('Deactive')}}</div>

                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="dropdown action-dropdown">
                                                        <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="flaticon-dots"></i>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                        @can('team.edit')
                                                            <li><a href="{{ url('admin/team-members/' . $data->id . '/edit') }}"
                                                                class="dropdown-item" title="{{ __('Edit')}}">
                                                                <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                            </a>
                                                        </li>
                                                            @endcan
                                                            @can('team.delete')
                                                            <li> <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal{{ $data->id }}"
                                                                title="{{ __('Delete')}}"><i class="flaticon-delete"></i> {{
                                                                __('Delete')}}</a>
                                                            </li>
                                                            @endcan
                                                        </ul>
                                                    </div>
                                                    <!------------------- model end ----------------------->
                                                </td>
                                            </tr>
                                            <!------- -------------model Start ------------------->
                                            <div class="modal fade" id="deleteModal{{$data->id}}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-dark">
                                                            <h6>{{ __('Are You Sure ?')}}</h6>
                                                            <p>
                                                                {{ __('Do you really want to delete these records? This process cannot be undone.') }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            {{-- form code start --}}
                                                            <form method="post"
                                                                action="{{ url('admin/team-members/'.$data->id .'/delete') }}
                                                            "data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">{{ __('No') }}</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">{{ __('Yes') }}</button>
                                                            </form>
                                                            {{-- form code end --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <!---------- loop  Print data show end-------------------->
                                    @endif
                                </tbody>
                            </table>
                            {{-- table code end --}}
                        </div>
                    </div>
                    <!-- End col -->
                </div>
            <!-- End row -->
            </div>
            <!-- End row -->
            <div class="modal fade delete-selected" id="exampleModal" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6 class="modal-heading">{{ __('Are You Sure') }} ?</h6>
                            <p>{{ __('Do you really want to delete selected item names here? This process
                                                                        cannot be undone') }}.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <form id="bulk_delete_form" method="post"
                                action="{{ route('members.bulk_delete') }}">
                                @csrf
                                @method('POST')
                                <button type="reset" class="btn btn-secondary translate-y-3"
                                    data-bs-dismiss="modal">{{ __('No') }}</button>
                                <button type="submit"
                                    class="btn btn-primary">{{ __('Yes') }}</button>
                            </form>
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
                <form id="bulk_delete_form" method="post" action="{{ route('manual.bulk_delete') }}">
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
