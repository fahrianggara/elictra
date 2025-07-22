@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination mb-0">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="Previous">
                    <span class="page-link" aria-hidden="true">
                        <i class="fas fa-angle-double-left"></i>
                    </span>
                </li>

                <li class="page-item disabled" aria-disabled="true" aria-label="Previous">
                    <span class="page-link" aria-hidden="true">
                        <i class="fas fa-angle-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <button class="page-link" wire:click="gotoPage(1)" wire:loading.attr="disabled">
                        <i class="fas fa-angle-double-left"></i>
                    </button>
                </li>

                <li class="page-item">
                    <button class="page-link" wire:click="previousPage" rel="prev" aria-label="Previous">
                        <i class="fas fa-angle-left"></i>
                    </button>
                </li>
            @endif

            @foreach (range(1, $paginator->lastPage()) as $i)
                @php
                    $currentPage = $paginator->currentPage();
                    $isCurrentPage = $currentPage == $i;
                    $inRange = false;
                    $onEachSide = 2; // 2 = 3 each pages, 3 = 4 pages, 4 = 5 pages, etc.

                    if ($currentPage === 1) { // first page
                        $inRange = $i <= $currentPage + $onEachSide;
                    } elseif ($currentPage === $paginator->lastPage()) { // last page
                        $inRange = $i >= $currentPage - $onEachSide;
                    } else { // middle page
                        if ($currentPage === 2) { // second page
                            $inRange = $i <= $currentPage + ($onEachSide - 1);
                        } elseif ($currentPage === $paginator->lastPage() - 1) { // second last page
                            $inRange = $i >= $currentPage - ($onEachSide - 1);
                        } else { // other pages
                            $inRange = $i >= $currentPage - ($onEachSide - 1) && $i <= $currentPage + 1;
                        }
                    }
                @endphp

                @if ($inRange)
                    <li class="page-item {{ $isCurrentPage ? 'active' : '' }}"
                        aria-current="{{ $isCurrentPage ? 'page' : '' }}">
                        @if ($isCurrentPage)
                            <span class="page-link">{{ $i }}</span>
                        @else
                            <button type="button" class="page-link" wire:click="gotoPage({{ $i }})"
                                wire:loading.attr="disabled">
                                {{ $i }}
                            </button>
                        @endif
                    </li>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <button class="page-link" wire:click="nextPage" rel="next" aria-label="Next">
                        <i class="fas fa-angle-right"></i>
                    </button>
                </li>

                <li class="page-item">
                    <button class="page-link" wire:click="gotoPage({{ $paginator->lastPage() }})"
                        wire:loading.attr="disabled">
                        <i class="fas fa-angle-double-right"></i>
                    </button>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                    <span class="page-link" aria-hidden="true">
                        <i class="fas fa-angle-right"></i>
                    </span>
                </li>

                <li class="page-item disabled" aria-disabled="true" aria-label="Next">
                    <span class="page-link" aria-hidden="true">
                        <i class="fas fa-angle-double-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
