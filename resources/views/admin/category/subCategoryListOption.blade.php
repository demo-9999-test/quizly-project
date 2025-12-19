<?php $dash.=''; ?>
@foreach($subcategories as $subcategory)
    <option value="{{$subcategory->id}}">{{$dash}}{{$subcategory->name}}</option>
    @if(count($subcategory->subcategory))
        @include('admin.category.subCategoryListOption',['subcategories' => $subcategory->subcategory])
    @endif
@endforeach
