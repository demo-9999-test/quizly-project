@extends('admin.layouts.master')
@section('title', 'Post')
@section('main-container')

<div class="dashboard-card">
    @component('admin.components.breadcumb',['thirdactive' => 'active'])
    @slot('heading')
    {{ __('Post') }}
    @endslot
    @slot('menu1')
    {{ __('Front Settings') }}
    @endslot
    @slot('menu2')
    {{ __('Post') }}
    @endslot
    @slot('button')

    <div class="col-md-6 col-lg-6">
        @can('blog.delete')
        <div class="widget-button">
            <a type="button" title="{{__('Delete')}}" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bulk_delete"><i class="flaticon-delete"></i> {{ __('Delete') }}</a>
            <a href="{{ route('post.trash') }}" type="button" title="{{__('Trash')}}" class="btn btn-success"><i class="flaticon-recycle"></i>{{ __('Trash') }}</a>
        </div>
        @endcan
    </div>
    @endslot
    @endcomponent
    <div class="contentbar">
        @include('admin.layouts.flash_msg')
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data" id="postForm">
                    @csrf
                    <div class="client-detail-block mb-4">
                        <div class="form-group mb-4">
                            <label for="title" class="form-label">{{ __('Title') }}<span class="required">*</span></label>
                            <input class="form-control mb-2" type="text" name="title" required id="title" placeholder="{{ __('Enter Your Title') }}" aria-label="title" value="{{ old('title') }}">
                            <div class="form-control-icon"><i class="flaticon-title"></i></div>
                        </div>
                        <button type="button" id="aiGenerateBtn" class="btn btn-primary btn-sm mb-4">
                            <i class="flaticon-ai-1"></i>{{ __('AI Generate') }}
                        </button>
                        <div class="form-group">
                            <label for="slug" class="form-label">{{ __('Slug') }}<span class="required">*</span></label>
                            <input class="form-control custom-input" type="text" name="slug" id="slug" placeholder="{{ __('Enter Your Slug') }}" aria-label="Slug" value="{{ old('slug') }}" required>
                            <div class="form-control-icon"><i class="flaticon-browser"></i></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-8">
                                    <label for="category_id" class="form-label">{{ __('Category') }}<span class="required">*</span></label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-4">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small class="recommended-font-size">{{ __('Create More Categories in Post Categories') }}</small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <select class="form-select" aria-label=" " name="category_id" id="category_id">
                                <option selected disabled>{{ __('Select Category') }}</option>
                                @foreach ($categoryData as $category)
                                <option value="{{ $category->id }}">{{ $category->categories }}</option>
                                @endforeach
                            </select>
                            <div class="form-control-icon"><i class="flaticon-pages"></i></div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-8">
                                    <label for="image" class="form-label">{{ __('Thumbnail Image') }}</label>
                                    <span class="required">*</span>
                                </div>
                                <div class="col-lg-4 col-md-4 col-4">
                                    <div class="suggestion-icon float-end">
                                        <div class="tooltip-icon">
                                            <div class="tooltip">
                                                <div class="credit-block">
                                                    <small class="recommended-font-size">{{ __('Recommended Size : 720x900') }}</small>
                                                </div>
                                            </div>
                                            <span class="float-end"><i class="flaticon-info"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input class="form-control" type="file" name="thumbnail_img" id="image" accept="image/*">
                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                        </div>
                        @if(!empty(env('UNSPLASH_ACCESS_KEY')) || !empty(env('PIXABAY_API_KEY')))

                        <!-- Image Source Selection -->
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Choose Image Source') }}</label>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="image_source" id="localImageRadio" value="local" checked>
                                <label class="btn btn-outline-primary" for="localImageRadio">{{ __('Upload Local Image') }}</label>
                                <input type="radio" class="btn-check" name="image_source" id="generatedImageRadio" value="generated">
                                <label class="btn btn-outline-primary" for="generatedImageRadio">{{ __('Select Generated Image') }}</label>
                            </div>
                        </div>
                    @endif

                    <!-- Local Image Upload Section -->
                    <div id="localImageUploadSection" class="mb-3">
                        <div class="form-group">
                            <label for="localImages" class="form-label">{{ __('Upload Local Image') }}</label>
                            <input type="file" class="form-control" id="localImages" name="local_images" accept="image/*">
                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                        </div>
                    </div>
                    <div id="generatedImageSelectSection" style="display: none;" class="mb-3">
                        <div class="form-group">
                            <label for="localImages" class="form-label">{{ __('Upload Generated Image') }}</label>
                            <input type="button" class="form-control" id="selectImagesBtn" value="Please select generated images">
                            <div class="form-control-icon"><i class="flaticon-upload"></i></div>
                        </div>
                    </div>

                        <!-- Selected Image Preview -->
                        <div id="selectedImagePreview" class="mt-3"></div>
                        <input type="hidden" name="generated_image_url" id="generatedImageUrl" value="">
                        <div class="form-group">
                            <label for="authorDescription" class="form-label">{{ __('Details') }}<span class="required">*</span></label>
                            <textarea class="form-control" name="desc" id="authorDescription" rows="4" placeholder="{{ __('Description will be generated automatically when you click on AI Generate') }}">{{ old('desc') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-4">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="sticky" class="form-label">{{ __('Sticky') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="sticky" name="sticky" value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="approved" class="form-label">{{ __('Approved') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="approved" name="approved" value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4">
                                <div class="status">
                                    <div class="form-group">
                                        <label for="is_featured" class="form-label">{{ __('Featured') }}</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-btn">
                            <button type="submit" class="btn btn-warning me-1" name="status" title="{{ __('Save Draft') }}" value="draft"><i class="flaticon-draft"></i> {{ __('Save Draft') }}</button>
                            <button type="submit" class="btn btn-success" name="status" title="{{ __('Publish') }}" value="publish"><i class="flaticon-paper-plane"></i> {{ __('Publish') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="client-detail-block">
                    <div class="project-main-block">
                        <div class="table-responsive no-btn-table">
                            <!-- table code start -->
                            <table  class="table data-table table-borderless"  id="example">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input" type="checkbox" id="checkboxAll"></th>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Approved') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-table">
                                    @if ($blog->isNotEmpty())
                                    @foreach ($blog as $data)
                                    <tr data-id="{{ $data->id }}">
                                        <td><input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input form-check-input' name='checked[]' value="{{ $data->id }}" id='checkbox{{ $data->id }}'></td>
                                        <td>
                                            @if (!empty($data->banner_img))
                                            <img src="{{ asset('/images/blog/' . $data->banner_img) }}" alt="{{ __('img') }}" class="widget-img" alt="{{ $data->title }}">
                                            @else
                                            <img src="{{ Avatar::create($data->title)->toBase64() }}" />
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('blog.details',['slug'=>$data->slug])}}" target="blank" title="{{ $data->title }}" class="url-tag">{{ $data->title }}</a>
                                        </td>
                                        <td>
                                            @if ($data->status == '0')
                                            <span class="badge text-bg-warning">{{ __('Draft') }}</span>
                                            @elseif ($data->status == '1')
                                            <span class="badge text-bg-success">{{ __('Published') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input status22" type="checkbox" role="switch" id="statusToggle" name="approved" data-id="{{ $data->id }}" value="{{ $data->approved }}" {{ $data->approved == 1 ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown action-dropdown">
                                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" title="{{__('Dropdown')}}" aria-expanded="false">
                                                    <i class="flaticon-dots"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{route('blog.details',['slug'=>$data->slug])}}" class="dropdown-item" title="{{ __('View') }}">
                                                            <i class="flaticon-view"></i> {{__('View')}}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item copy-post" data-id="{{ $data->id }}" title="{{ __('Copy') }}">
                                                            <i class="flaticon-copy"></i> {{ __('Copy') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        @can('blog.edit')
                                                        <a href="{{ url('admin/post/' . $data->id . '/edit') }}" class="dropdown-item" title="{{ __('Edit') }}">
                                                            <i class="flaticon-editing"></i> {{ __('Edit') }}
                                                        </a>
                                                        @endcan
                                                    </li>
                                                    <li>
                                                        @can('blog.delete')
                                                        <a class="dropdown-item" title="{{__('Delete')}}" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $data->id }}" title="{{ __('Delete') }}">
                                                            <i class="flaticon-delete"></i> {{ __('Delete') }}
                                                        </a>
                                                        @endcan
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- modal Start -->
                                     <div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Are You Sure ?') }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{ __('Do you really want to delete') }}? {{ __('This process cannot be undone.') }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post" action="{{ url('admin/post/' . $data->id . '/delete') }}" class="pull-right">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="reset" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{ __('No') }}</button>
                                                        <button type="submit" title="{{ __('Yes') }}" class="btn btn-primary">{{ __('Yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- modal end -->
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">{{ __('No blogs available or found') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!-- table code end -->
                            <div class="d-flex justify-content-end">
                                <div class="pagination pagination-circle mb-3">
                                    {{ $blog->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Rest of your existing UI code -->
        </div>
    </div>
</div>

<!-- Image Selection Modal -->
<div class="modal fade" id="imageSelectionModal" tabindex="-1" aria-labelledby="imageSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageSelectionModalLabel">{{ __('Select an Image') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalImageSelectionArea" class="row g-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary" id="saveSelectedImage">{{ __('Save Selection') }}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="aiModelSelectionModal" tabindex="-1" aria-labelledby="aiModelSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="aiModelSelectionModalLabel">{{ __('Select AI Model') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="card h-100 cursor-pointer ai-model-card" data-model="chatgpt">
                <div class="ratio ratio-1x1">
                  <img src="{{ asset('admin_theme/assets/images/blog/chatgpt.jpg') }}" alt="ChatGPT" class="card-img-top object-fit-cover">
                </div>
                <div class="card-body">
                  <h5 class="card-title">{{ __('ChatGPT') }}</h5>
                  <p class="card-text">{{ __('Generate description using OpenAI ChatGPT model.') }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100 cursor-pointer ai-model-card" data-model="cohere">
                <div class="ratio ratio-1x1">
                  <img src="{{ asset('admin_theme/assets/images/blog/cohere.png') }}" alt="Cohere" class="card-img-top object-fit-cover">
                </div>
                <div class="card-body">
                  <h5 class="card-title">{{ __('Cohere') }}</h5>
                  <p class="card-text">{{ __('Generate description using Cohere language model.') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Image Source Selection Modal -->
<div class="modal fade" id="imageSourceSelectionModal" tabindex="-1" aria-labelledby="imageSourceSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageSourceSelectionModalLabel">{{ __('Select Image Source') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="card h-100 cursor-pointer image-source-card" data-source="pixabay">
                <div class="ratio ratio-1x1">
                  <img src="{{ asset('admin_theme/assets/images/blog/pixabay.png') }}" alt="Pixabay" class="card-img-top object-fit-cover">
                </div>
                <div class="card-body">
                  <h5 class="card-title">{{ __('Pixabay') }}</h5>
                  <p class="card-text">{{ __('Generate images using Pixabay API.') }}</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100 cursor-pointer image-source-card" data-source="unsplash">
                <div class="ratio ratio-1x1">
                  <img src="{{ asset('admin_theme/assets/images/blog/unsplash.jpg') }}" alt="Unsplash" class="card-img-top object-fit-cover">
                </div>
                <div class="card-body">
                  <h5 class="card-title">{{ __('Unsplash') }}</h5>
                  <p class="card-text">{{ __('Generate images using Unsplash API.') }}</p>
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
                <button type="button" class="btn btn-secondary" title="{{ __('No') }}" data-bs-dismiss="modal">{{
                    __('No') }}</button>
                <form id="bulk_delete_form" method="post" action="{{ route('post.bulk_delete') }}">
                    @csrf
                    @method('POST')
                    <button type="submit" title="{{ __('Yes') }}" class="btn btn-primary">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Delete Modal end -->
@endsection

@section('scripts')
<script src="{{ asset('admin_theme/assets/js/blog.js') }}"></script>
<script src="{{ asset('admin_theme/assets/js/blog-ai.js') }}"></script>
<script>
    window.routes = {
        checkEnvVariables: "{{ route('check.env.variables') }}",
        UpdateEnvVariables: "{{ route('update.env.variables') }}",
        genrateblog: "{{ route('post.generate-description') }}",
        genrateimage: "{{ route('post.generate-images') }}",
        copyblog: "{{ route('post.copy') }}",
    };
</script>
@endsection
