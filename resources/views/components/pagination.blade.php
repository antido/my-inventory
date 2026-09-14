@props(['paginator'])

@if ($paginator->hasPages())
    <nav class="pagination" aria-label="Pagination">
        <p class="pagination-summary">
            Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }} users
        </p>

        <div class="pagination-links">
            @if ($paginator->onFirstPage())
                <span class="pagination-link disabled" aria-disabled="true">Previous</span>
            @else
                <a class="pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
            @endif

            @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                @if ($page === $paginator->currentPage())
                    <span class="pagination-link active" aria-current="page">{{ $page }}</span>
                @else
                    <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
            @else
                <span class="pagination-link disabled" aria-disabled="true">Next</span>
            @endif
        </div>
    </nav>
@endif
