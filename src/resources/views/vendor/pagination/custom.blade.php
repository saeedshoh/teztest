@if ($paginator->hasPages())
    <ul class="pagination pagination-rounded justify-content-center mt-4">

        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i class="mdi mdi-chevron-left"></i></a>
            </li>
        @endif

        @foreach ($elements as $element)

            @if (is_string($element))
                <li class="page-item disabled"><span>{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @else
                        <li><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
            </li>
        @else
            <li class="page-item disabled">
                <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
            </li>
        @endif
    </ul>
@endif
