@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" class="mr-2">&lsaquo;&lsaquo;Older</a></li>
        @else
            <li class="disabled mr-2" aria-disabled="true"><span>&lsaquo;&lsaquo; Older</span></li>
        @endif


        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true"><span>Newer &rsaquo;&rsaquo;</span></li>
        @else
            <li class=""><a href="{{ $paginator->previousPageUrl() }}" rel="prev">Newer &rsaquo;&rsaquo;</a></li>
        @endif


    </ul>
@endif
