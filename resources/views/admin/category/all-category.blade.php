<ul class="hummingbird-treeview-converter list-unstyled" data-radio-name="category_id">
    @foreach ($allcategories as $categorys)
        <li data-id="{{ $categorys->id }}">{{ $categorys->name }} ({{ $categorys->slug }})</li>

        @if (count($categorys->subcategory))
            @include('admin.category.sub-category-list-tree', [
                'subcategories' => $categorys->subcategory,
                'dash' => '-' // initial dash
            ])
        @endif
    @endforeach
</ul>
