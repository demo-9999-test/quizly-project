@extends('admin.layouts.master')
@section('title', 'Open AI')
@section('main-container')

<!-- Breadcrumb Start -->
<div class="dashboard-card">
    @component('admin.components.breadcumb',['secondaryactive' => 'active'])
    @slot('heading')
    {{ __('Open AI') }}
    @endslot
    @slot('menu1')
    {{ __('Open AI') }}
    @endslot
<!-- Breadcrumb End -->

@slot('button')
<div class="col-md-6 col-lg-6">
    <div class="widget-button">
        @can('openai.manage')
        <a type="button" class="btn btn-danger" title="{{ __('Delete') }}" data-bs-toggle="modal"
            data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
        @endcan
    </div>
</div>
@endslot
@endcomponent
<!--start contentbar -->
    <div class="contentbar ">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-12">
                <div class="client-detail-block user-page">
                    <div class="table-responsive">
                        <!-- Table start-->
                        <table class="table data-table table-borderless"  id="example">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkboxAll" class="form-check-input"></th>
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Genrate') }}</th>
                                    <th>{{ __('Prompt') }}</th>
                                    <th>{{ __('Response') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <!-- loop  Print data show Start --->
                            <tbody>
                                @foreach($openai as $key => $test)
                                @if(isset($test))
                                <tr>
                                    <td><input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input form-check-input'
                                            name='checked[]' value="{{ $test->id }}" id='checkbox{{ $test->id }}'>
                                    </td> 
                                    <td class="py-1">
                                        {{ ($openai->currentPage() - 1) * $openai->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $test->generate }}
                                    </td>
                                    <td>
                                        {{ $test->prompt }}
                                    </td>
                                    @if($test->generate == 'Image Generate')
                                    @if(!empty($test->response))
                                    <td>
                                        <div class="ai-generate-image">
                                            <img src="{{ $test->response }}" class="img-fluid img-circle" alt="{{__('Image')}}">
                                            <div class="img-output-icon">
                                                <ul>
                                                    <li><a href="{{ $test->response }}" title="{{__('Download')}}" download><i class="flaticon-download"></i></a></li>
                                                    <li><a href="{{ $test->response }}" data-lightbox="homePortfolio"
                                                            title="{{__('View')}}" target="_blank"><i
                                                            class="flaticon-view"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                    @else

                                    @php
                                    $jsonData = $test->response;
                                    $decodedData = json_decode($jsonData, true);
                                    $content = $decodedData['content'] ?? '';
                                    $words = str_word_count($content, 1);
                                    $limitedContent = implode(' ', array_slice($words, 0, 100));
                                    @endphp

                                    <td>{!! nl2br($limitedContent) !!}</td>
                                    @endif

                                    <td>
                                        <div class="dropdown action-dropdown">
                                            <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="flaticon-dots"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $test->id }}"
                                                        title="{{ __('Delete')}}"><i class="flaticon-delete"></i> {{__('Delete')}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                 <!-- delete Modal start -->
                                 <div class="modal fade" id="exampleModal{{ $test->id }}" tabindex="-1"
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
                                                        action="{{ url('admin/openai/delete/'.$test->id) }}"
                                                        class="pull-right">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="reset" class="btn btn-secondary"
                                                            title="{{ __('No') }}" data-bs-dismiss="modal">{{
                                                            __('No')
                                                            }}</button>
                                                        <button type="submit" title="{{ __('Yes') }}"
                                                            class="btn btn-primary">{{ __('Yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- delete Model ended -->
                                @endif
                                @endforeach

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <div class="pagination pagination-circle mb-3">
                                {{ $openai->links() }}
                            </div>
                        </div>
                        <!-- Table end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--End Contentbar-->
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
                <form id="bulk_delete_form" method="post" action="{{ route('openai.bulk.delete') }}">
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
