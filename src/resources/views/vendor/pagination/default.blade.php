@if ($paginator->hasPages())
    <nav class="pagination">
        @foreach ($elements as $element)
            @if (is_string($element))
                <div class="pagination__number">
                    <p class="disabled" aria-disabled="true"><span>{{ $element }}</span></p>
                </div>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <a href="{{ $url }}">
                        @if ($page == $paginator->currentPage())
                            <div class="pagination__number pagination__number--active">
                                <p class="active" aria-current="page"><span>{{ $page }}</span></p>
                            </div>
                        @else
                            <div class="pagination__number">
                                <span>{{ $page }}</span>
                            </div>
                        @endif
                    </a>
                @endforeach
            @endif
        @endforeach
    </nav>
@endif
