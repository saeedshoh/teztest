@can('view_'.$entity)

@if(in_array('view', $actions))
<a href="{{ route($entity.'.show', [Str::singular($entity) => $id])  }}" class="mr-3 text-primary"
   data-toggle="tooltip" data-placement="top"  data-original-title="View">
    <i class="mdi mdi-eye font-size-18"></i>
</a>
@endif
@endcan

@can('edit_'.$entity)
@if(in_array('edit', $actions))
    <a href="{{ route($entity.'.edit', [Str::singular($entity) => $id])  }}" class="mr-3 text-primary"
       data-toggle="tooltip" data-placement="top"  data-original-title="Edit">
        <i class="mdi mdi-pencil font-size-18"></i>
    </a>
@endif
@endcan


    @if(in_array('audit', $actions))
        <a href="{{ route($entity.'.audit', [Str::singular($entity) => $id])  }}" class="mr-3 text-primary"
           data-toggle="tooltip" data-placement="top"  data-original-title="Edit">
            <i class="mdi mdi-history font-size-18"></i>
        </a>
    @endif


@can('delete_'.$entity)
@if(in_array('delete', $actions))
    {!! Form::open(['method' => 'delete', 'url' => route($entity.'.destroy', [Str::singular($entity) => $id]), 'style' => 'display: inline', 'onSubmit' => 'return confirm("Are yous sure wanted to delete it?")']) !!}
        <button type="submit"
                class="text-danger"
                data-toggle="tooltip"
                data-placement="top"
                style="border: none; background: transparent; padding: 0;"
                data-original-title="Delete">
            <i class="mdi mdi-close font-size-18"></i>
        </button>
    {!! Form::close() !!}
@endif
@endcan


