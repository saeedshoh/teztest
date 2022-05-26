<li>
    @if($sub_categories->icon)<img src="{{$sub_categories->IconUri}}" width="20">@endif
    <b>{{ $sub_categories->name }} <span class="text-danger">({{$sub_categories->products_count}})</span></b>
    <a href="{{route('categories.create', ['id' => $sub_categories->id, 'name' => $sub_categories->name])}}"> <i class="mdi mdi-folder-plus font-size-18"></i></a>
    <a href="{{ route('categories.edit', $sub_categories->id) }}">  <i class="mdi mdi-pencil font-size-18"></i></a>
    <a href="{{ route('categories.audit', $sub_categories->id) }}">
        <i class="mdi mdi-history font-size-18"></i>
    </a>
    {!! Form::open(['method' => 'delete', 'url' => route('categories.destroy', ['category' => $sub_categories->id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to delete it?")']) !!}
    <button type="submit"
            class="text-danger"
            data-toggle="tooltip"
            data-placement="top"
            style="border: none; background: transparent; padding: 0;"
            data-original-title="Delete">
        <i class="mdi mdi-close font-size-18"></i>
    </button>
    {!! Form::close() !!}
</li>

@if (count($sub_categories->subCategoryAdmin) > 0)
    <ul style="list-style-type: none;">
        @if(count($sub_categories->subCategoryAdmin) > 0)
            @foreach ($sub_categories->subCategoryAdmin as $subCategories)
                @include('product.categories.sub_categories', ['sub_categories' => $subCategories])
            @endforeach
        @endif
    </ul>
@endif
