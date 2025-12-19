@foreach ($childcategories as $childcategory)
    @if (is_array($childcategory->sub_category_id) && in_array($subcategory->id, $childcategory->sub_category_id))
        <tr>
            <!-- Checkbox -->
            <td>
                <input type="checkbox" form="bulk_delete_form2"
                       class="check filled-in material-checkbox-input form-check-input childcategory-checkbox"
                       data-parent="{{ $subcategory->id }}"
                       name="checked[]"
                       data-subcategory-id="{{ $subcategory->id }}"
                       value="{{ $childcategory->id }}"
                       id="checkbox{{ $childcategory->id }}"
                       onchange="toggleSubcategoryCheckbox({{ $childcategory->id }})">
            </td>

            <!-- Name with badge -->
            <td>
                {{ $dash }}
                <span class="badge {{ $badgeClass }}">{{ $prefix }}</span>
                {{ $childcategory->name }}
            </td>

            <!-- Parent Subcategory Name -->
            <td>{{ $subcategory->name }}</td>

            <!-- Status Switch -->
            <td>
                <div class="form-check form-switch">
                    <input class="form-check-input childcategorystatus" type="checkbox" role="switch"
                           id="childcategorystatus{{ $childcategory->id }}"
                           name="status"
                           data-id="{{ $childcategory->id }}"
                           value="{{ $childcategory->status }}"
                           {{ $childcategory->status == 1 ? 'checked' : '' }}>
                </div>
            </td>

            <!-- Action Dropdown -->
            <td>
                <div class="dropdown action-dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="flaticon-dots"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url('admin/childcategory/' . $childcategory->id . '/edit') }}"
                               class="dropdown-item" title="Edit">
                                <i class="flaticon-editing"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item deletechildcategory" href="#" data-bs-toggle="modal"
                               data-bs-target="#exampleModal{{ $childcategory->id }}"
                               data-subcategory-id="{{ $subcategory->id }}" title="Delete">
                                <i class="flaticon-delete"></i> Delete
                            </a>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade childmodal" id="exampleModal{{ $childcategory->id }}" tabindex="-1"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Are You Sure?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p>Do you really want to delete? This process cannot be undone.</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <form method="post" action="{{ url('admin/childcategory/' . $childcategory->id . '/delete') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" class="subcategory_id_hidden" name="subcategory_id" value="{{ $subcategory->id }}">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
