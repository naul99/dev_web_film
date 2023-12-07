@if ($paginator->hasPages())
    <ul class="pagination mb-sm-0">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
            </li>
        @endif
        @if ($paginator->currentPage() > 3)
            <li class="page-item"><a href="{{ $paginator->url(1) }}" class="page-link">1</a></li>
        @endif
        @if ($paginator->currentPage() > 4)
            <li class="page-item"><span class="page-link">...</span></li>
        @endif
        @foreach (range(1, $paginator->lastPage()) as $i)
            @if ($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                @else
                    <li class="page-item"><a href="{{ $paginator->url($i) }}" class="page-link">{{ $i }}</a>
                    </li>
                @endif
            @endif
        @endforeach
        @if ($paginator->currentPage() < $paginator->lastPage() - 3)
        <li class="page-item"><span class="page-link">...</span></li>
        @endif
        @if ($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="page-item"><a class="page-link"
                    href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
            </li>
        @else
            <li class="page-item disabled"><a href="" class="page-link">
                    <i class="mdi mdi-chevron-right"></i></a>
            </li>
        @endif
    </ul>
@endif
