@if ($paginator->hasPages())
    <nav class="pagination">
        @php
            $maxLinks = 3; // Maximum number of pagination links to display
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            
            $startRange = $currentPage - floor($maxLinks / 2);
            $endRange = $currentPage + floor($maxLinks / 2);
            
            if ($startRange < 1) {
                $endRange += abs($startRange) + 1;
                $startRange = 1;
            }
            
            if ($endRange > $lastPage) {
                $startRange -= $endRange - $lastPage;
                $endRange = $lastPage;
            }
            
            $showFirstPageLink = $startRange > 1;
            $showLastPageLink = $endRange < $lastPage;
        @endphp

        @if ($showFirstPageLink)
            <a href="{{ $paginator->url(1) }}">
                <div class="pagination__number">
                    <span>1</span>
                </div>
            </a>
        @endif

        @if ($showFirstPageLink && $startRange > 2)
            <div class="pagination__number">
                <span>...</span>
            </div>
        @endif

        @for ($i = $startRange; $i <= $endRange; $i++)
            @if ($i == $currentPage)
                <div class="pagination__number pagination__number--active">
                    <p class="active" aria-current="page"><span>{{ $i }}</span></p>
                </div>
            @else
                <a href="{{ $paginator->url($i) }}">
                    <div class="pagination__number">
                        <span>{{ $i }}</span>
                    </div>
                </a>
            @endif
        @endfor

        @if ($showLastPageLink && $endRange < $lastPage - 1)
            <div class="pagination__number">
                <span>...</span>
            </div>
        @endif

        @if ($showLastPageLink)
            <a href="{{ $paginator->url($lastPage) }}">
                <div class="pagination__number">
                    <span>{{ $lastPage }}</span>
                </div>
            </a>
        @endif
    </nav>
@endif
