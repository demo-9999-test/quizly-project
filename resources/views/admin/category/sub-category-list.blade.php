@foreach ($subcategories as $subcategory)
    <tr>
        <td>
            <input type='checkbox' form='bulk_delete_form1'
                class='check filled-in material-checkbox-input form-check-input subcategory-checkbox'
                data-parent="{{ $subcategory->category_id }}" name='checked[]' value="{{ $subcategory->id }}"
                id='checkbox{{ $subcategory->id }}' onchange="toggleSubcategoryCheckbox({{ $subcategory->id }})">
        </td>
        <td> {{ $dash }}<span class="badge category-badge {{ $badgeClass }}">{{ $prefix }}</span>
            {{ $subcategory->name }}</td>

        <td>{{ $category->name }}</td>
        <td>
            <div class="form-check form-switch">
                <input class="form-check-input subcategorystatus" type="checkbox" role="switch" id="subcategorystatus"
                    name="status" data-id="{{ $subcategory->id }}" value="{{ $subcategory->status }}"
                    {{ $subcategory->status == 1 ? 'checked' : '' }}>
            </div>
        </td>
        <td>
            <div class="dropdown action-dropdown">
                <a class="dropdown-toggle" title="{{__('Dropdown')}}" href="#" role="bucomposer require omise/omise
                    tton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="flaticon-dots"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ url('admin/subcategory/' . $subcategory->id . '/edit') }}" class="dropdown-item"
                            title="{{ __('Edit') }}">
                            <i class="flaticon-editing"></i> {{ __('Edit') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#exampleModal{{ $subcategory->id }}" title="{{ __('Delete') }}"><i
                                class="flaticon-delete"></i> {{ __('Delete') }}</a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>

    @include('admin.category.child-category-list', [
        'childcategories' => ($childCategories = App\Models\ChildCategory::all()),
        'dash' => '--|-',
        'prefix' => 'Child',
        'badgeClass' => 'child-badge text-bg-warning',
    ])





    {{-- -------------model Start ------------------- --}}
    <div class="modal fade" id="exampleModal{{ $subcategory->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        {{ __('Are You Sure ?') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Do you really want to delete') }} ?
                        {{ __('This process cannot be undone.') }}</p>
                </div>
                <div class="modal-footer">
                    <form method="post" action="{{ url('admin/subcategory/' . $subcategory->id . '/delete') }}"
                        class="pull-right">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('No') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- ------------- model end ------------------------- --}}
@endforeach


<!-- Bulk Delete Modal end -->
