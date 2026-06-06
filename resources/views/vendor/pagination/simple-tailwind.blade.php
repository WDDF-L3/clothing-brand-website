@if ($paginator->hasPages())
<nav style="display:flex; justify-content:center; align-items:center; gap:8px; font-size:12px; letter-spacing:.1em; text-transform:uppercase;">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span style="padding:8px 16px; border:1px solid var(--border); color:var(--stone); cursor:default;">← Prev</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" style="padding:8px 16px; border:1px solid var(--border); color:var(--ink); transition:all .2s;">← Prev</a>
    @endif

    {{-- Page info --}}
    <span style="color:var(--muted);">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" style="padding:8px 16px; border:1px solid var(--border); color:var(--ink); transition:all .2s;">Next →</a>
    @else
        <span style="padding:8px 16px; border:1px solid var(--border); color:var(--stone); cursor:default;">Next →</span>
    @endif
</nav>
@endif
