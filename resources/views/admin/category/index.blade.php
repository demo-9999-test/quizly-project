@extends('admin.layouts.master')
@section('title', 'Categories')
@section('main-container')

    <div class="dashboard-card">
        @component('admin.components.breadcumb', ['secondaryactive' => 'active'])
            @slot('heading')
                {{ __('Categories') }}
            @endslot
            @slot('menu1')
                {{ __('Categories') }}
            @endslot
            @slot('button')

                <div class="col-md-7 col-lg-6">
                    <div class="widget-button">
                        <a href="{{ route('category.import') }}" type="button" title="{{ __('Import') }}" class="btn btn-info p-2"> <i
                                class="flaticon-import"></i>
                            {{ __('Import') }}</a>
                        <a href="{{ route('category.export') }}" type="button" class="btn btn-success" title=" {{ __('Export') }}">
                            <i class="flaticon-recycle"></i>
                            {{ __('Export') }}</a>
                        <a type="button" title="{{ __('Delete') }}" class="btn btn-danger " data-bs-toggle="modal"
                            data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
                    </div>
                </div>
            @endslot
        @endcomponent
        <div class="contentbar">
            @include('admin.layouts.flash_msg')
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!-- form Code start -->
                    @if (isset($editcategory))
                        <form role="form" method="post" enctype="multipart/form-data"
                            action="{{ route('category.update', $editcategory->id) }}">
                            @method('PUT')
                            @csrf
                            @else
                            <form role="form" method="post" enctype="multipart/form-data" ...>
                                @csrf
                                @endif
                                <div class="client-detail-block">
                                    <div class="form-group">
                                        <label for="title" class="form-label">{{ __('Category') }}<span
                                            class="required">*</span></label>
                                        <input class="form-control" type="text" name="name"
                                            value="{{ old('name', $editcategory->name ?? '') }}" required id="title"
                                            placeholder="Enter Your Category" aria-label="Category">
                                        <div class="form-control-icon"><i class="flaticon-heading"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="slug" class="form-label">{{ __('Slug') }}<span
                                        class="required">*</span></label>
                                    <input class="form-control custom-input" type="text" name="slug"
                                        value="{{ old('slug', $editcategory->slug ?? '') }}" id="slug"
                                        placeholder="Enter Your Slug" aria-label="Slug" value="{{ old('slug') }}" readonly
                                        required>
                                    <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                                </div>
                                <div class="form-group">
                                    <label for="slug" class="form-label">{{ __('Category Type') }}<span
                                        class="required">*</span></label>
                                    <select name="categorytype" id="categorytype" class="form-control">
                                        <option selected disabled>{{ __('Select Category Type') }}</option>
                                        <option value="-1"
                                            {{ old('categorytype', isset($editcategory) ? ($editcategory->parent_id == -1 ? 'selected' : '') : '') }}>
                                            {{ __('Category') }}
                                        </option>
                                   </select>
                                   <div class="form-control-icon"><i class="flaticon-browser"></i>
                                </div>
                            </div>
                                {{-- <input type="hidden" name="" value="" id=""> --}}
                                <div class="form-group hidden" id="category">
                                    <label for="slug" class="form-label">{{ __(' Category') }}<span
                                    class="required">*</span></label>
                                    <select name="parent_id" class="form-control">
                                        <option selected disabled>{{ __('Select Category') }}</option>
                                        @if ($categories)
                                        @foreach ($categories as $category)
                                        <?php $dash = ''; ?>
                                        <option value="{{ $category->id }}"
                                            {{ isset($editcategory) && $category->id == $editcategory->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="form-control-icon"><i class="flaticon-browser"></i>
                            </div>
                        </div>
                        <div class="form-group hidden" id="subcategory">
                            <label for="slug" class="form-label">{{ __('Sub  Category') }}<span
                                    class="required">*</span></label>
                            <select class="form-select select2-multi-select form-control" aria-label=" "
                                name="sub_category_id[]" multiple>
                                @forelse ($categories as $category)
                                @foreach ($category->subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}"
                                {{ isset($editcategory) && is_array($editcategory->sub_category_id) && in_array($subcategory->id, $editcategory->sub_category_id) ? 'selected' : '' }}>
                                {{ $subcategory->name }}</option>
                                @endforeach
                                @empty
                                <option value="" disabled>{{ __('No categories available') }}</option>
                                @endforelse
                            </select>
                            <div class="form-control-icon"><i class="flaticon-browser"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-8">
                                    <label for="image" class="form-label">{{ __('Image') }}</label>
                                    
                                </div>
                                <div class="col-lg-4 col-md-4 col-4">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small
                                                        class="recommended-font-size">{{ __('Recommended Size :720x900') }}</small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input class="form-control" type="file" name="image" id="image">
                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="icon" class="form-label">{{ __('icon') }}</label>
                            <input class="form-control iconpicker-component" type="text" name="icon"
                                id="icon" placeholder="Please Enter Your icon" aria-label="icon" value=""
                                required="">
                            <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle iconpicker-toggle"
                                data-selected="bi bi-0-circle" data-icon="bi bi-0-circle" data-bs-toggle="dropdown">
                                <i class="bi bi-0-circle"></i>
                            </button>
                            <div class="dropdown-menu"></div>
                            <div class="form-control-icon"><i class="flaticon-select"></i></div>
                        </div> --}}
                        <div class="form-group">
                            <label for="icon" class="form-label">{{ __('Icon') }}<span class="required">*</span></label>
                            <input class="form-control iconpicker-component" type="text" name="icon"
                                id="icon" placeholder="Please Enter Your Icon" aria-label="icon"
                                value="{{ old('icon', $editcategory->icon ?? '') }}" required>
                            <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle iconpicker-toggle"
                                data-selected="{{ old('icon', $editcategory->icon ?? 'bi bi-0-circle') }}"
                                data-icon="{{ old('icon', $editcategory->icon ?? 'bi bi-0-circle') }}"
                                data-bs-toggle="dropdown">
                                <i class="{{ old('icon', $editcategory->icon ?? 'bi bi-0-circle') }}"></i>
                            </button>
                            <div class="dropdown-menu"></div>
                            <div class="form-control-icon">
                                <i class="flaticon-select"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="form-label">{{ __('Description') }}<span class="required">*</span></label>
                            
                            <textarea class="form-control form-control-padding_15" name="description" id="desc" cols="30"
                                rows="5" placeholder="{{ __('Enter description') }}">  {{ old('description', $editcategory->description ?? '') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="status" class="form-label">{{ __('Status') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="status"
                                                role="switch" id="status_toggle"
                                                {{ isset($editcategory) && $editcategory->status == 1 ? 'checked' : '' }}
                                                checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-btn">
                            <button type="submit" class="btn btn-primary">
                                <i class="flaticon-upload-1"></i>
                                @if (isset($editcategory))
                                    {{ __('Update') }}
                                @else
                                    {{ __('Submit') }}
                                @endif
                            </button>
                        </div>
                    </div>
                    </form>
                    <!-- form Code end -->
                </div>
                <div class="col-lg-8 col-md-6">
                    <div class="client-detail-block">

                        <div class="table-responsive no-btn-table">
                            <!-- table code start -->
                            <table class="table data-table table-borderless" id="example">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input" type="checkbox" id="checkboxAll"></th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Parent Category') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <!-- loop Print data show start -->
                                <tbody>
                                    @if (isset($categories))
                                    @foreach ($categories as $category)
                                    <tr data-id="{{ $category->id }}">
                                        <td>
                                            <input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input form-check-input categoryselect'
                                            name='checked[]' value="{{ $category->id }}"
                                            id='checkbox{{ $category->id }}'
                                            onchange="toggleSubcategoryCheckboxes({{ $category->id }})">
                                        </td>
                                        <td> <span class="badge p-category-badge parent-badge text-bg-success ">Parent</span>{{ $category->name }}</td>
                                        <td>
                                            @if ($category->parent_id != '-1')
                                                {{ $category->subcategory->name }}
                                            @else
                                                {{ __('Main Category') }}
                                            @endif
                                        </td>
                                        <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input categorystatus" type="checkbox"
                                                role="switch" id="categorystatus" name="status"
                                                data-id="{{ $category->id }}"
                                                value="{{ $category->status }}"
                                                {{ $category->status == 1 ? 'checked' : '' }}>
                                        </div>
                                        </td>
                                        <td>
                                        <div class="dropdown action-dropdown">
                                            <a class="dropdown-toggle" title="{{ __('Dropdown') }}"
                                                    href="#" role="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="flaticon-dots"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                    <li>
                                                    <a href="{{ url('admin/category/' . $category->id . '/edit') }}"
                                                        class="dropdown-item" title="{{ __('Edit') }}">
                                                    <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                    </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{ $category->id }}"
                                                            title="{{ __('Delete') }}"><i
                                                                class="flaticon-delete"></i>{{ __('Delete') }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                            @if (count($category->subcategories))
                                            @include('admin.category.sub-category-list', [
                                                'subcategories' => $category->subcategories,
                                                'dash' => '|-',
                                                'prefix' => 'Sub',
                                                'badgeClass' => 'text-bg-primary',
                                            ])
                                            @endif

                                            {{-- -------------model Start ------------------- --}}
                                            <div class="modal fade" id="exampleModal{{ $category->id }}" tabindex="-1"
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
                                                                action="{{ url('admin/category/' . $category->id . '/delete') }}"
                                                                class="pull-right">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">{{ __('No') }}</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">{{ __('Yes') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- ------------- model end ------------------------- --}}
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <!-- table code end -->

                            <div class="d-flex justify-content-end">
                                <div class="pagination pagination-circle mb-3">
                                </div>
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
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('No') }}</button>
                    <form id="bulk_delete_form" method="post" action="{{ route('category.bulk_delete') }}">
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

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.icp-dd').iconpicker();
            $('.icp-dd').on('iconpickerSelected', function(e) {
                $('#icon').val(e.iconpickerValue);
                $(this).find('i').attr('class', e.iconpickerValue);
            });
        });
    </script>
@endsection
