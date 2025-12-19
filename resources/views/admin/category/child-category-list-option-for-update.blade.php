@foreach($childcategories as $childcategory)
    @if($subcategory->id != $childcategory->id)
        <option value="{{ $childcategory->id }}"
            @if(request()->old('child_category_id') == $childcategory->id || (isset($selectedId) && $selectedId == $childcategory->id))
                selected
            @endif>
            {{ $dash ?? '' }} {{ $childcategory->name }}
        </option>
    @endif

    @if ($childcategory->childcategories && count($childcategory->childcategories))
        @include('admin.category.child-category-list-option-for-update', [
            'childcategories' => $childcategory->childcategories,
            'dash' => ($dash ?? '') . '--|',
            'prefix' => $prefix ?? '',
            'badgeClass' => $badgeClass ?? '',
            'selectedId' => $selectedId ?? null,
        ])
    @endif
@endforeach
