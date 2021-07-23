@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="nr disabled"><a href="#">{{ trans('wikipedia-plugin.previous') }}</a></li>
        @else
            <li class="nr"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">{{ trans('wikipedia-plugin.previous') }}</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="nr disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="nr active"><a href="#">{{ $page }}</a></li>
                    @else
                        <li class="nr"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="nr"><a href="{{ $paginator->nextPageUrl() }}">{{ trans('wikipedia-plugin.next') }}</a></li>
        @else
            <li class="nr disabled"><a href="#">{{ trans('wikipedia-plugin.next') }}</a></li>
        @endif
    </ul>
@endif