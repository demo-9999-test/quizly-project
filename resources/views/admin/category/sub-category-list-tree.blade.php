@if(count($subcategories) > 0)
    @foreach($subcategories as $subcategory)
        <li id="{{ $subcategory->id }}">{{$dash}}{{ $subcategory->name }} ({{ $subcategory->slug }})</li>

        {{-- Recursive call for sub-subcategories --}}
        @if(count($subcategory->subcategory) > 0)
            @include('admin.category.sub-category-list-tree', [
                'subcategories' => $subcategory->subcategory,
                'dash' => $dash . '-' // pass incremented dash
            ])
        @endif
    @endforeach
@endif
