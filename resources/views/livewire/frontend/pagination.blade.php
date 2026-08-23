@php
    $scrollTo = $scrollTo ?? '.tour-catalog-grid';
    $scrollIntoView = $scrollTo === false
        ? ''
        : "(document.querySelector('{$scrollTo}') || document.body).scrollIntoView({ behavior: 'smooth', block: 'start' })";
@endphp

@if ($paginator->hasPages())
    <nav class="page-nav-wrap text-center" role="navigation" aria-label="Tour results pagination">
        <ul class="livewire-theme-pagination">
            <li>
                @if ($paginator->onFirstPage())
                    <span class="page-numbers disabled" aria-disabled="true" aria-label="Previous page">
                        <i class="far fa-arrow-left" aria-hidden="true"></i>
                    </span>
                @else
                    <button type="button" class="page-numbers" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoView }}" wire:loading.attr="disabled" rel="prev" aria-label="Previous page">
                        <i class="far fa-arrow-left" aria-hidden="true"></i>
                    </button>
                @endif
            </li>

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="page-numbers dots" aria-hidden="true">&hellip;</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}">
                            @if ($page == $paginator->currentPage())
                                <span class="page-numbers current" aria-current="page" aria-label="Page {{ $page }}">{{ $page }}</span>
                            @else
                                <button type="button" class="page-numbers" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoView }}" wire:loading.attr="disabled" aria-label="Go to page {{ $page }}">{{ $page }}</button>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            <li>
                @if ($paginator->hasMorePages())
                    <button type="button" class="page-numbers" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoView }}" wire:loading.attr="disabled" rel="next" aria-label="Next page">
                        <i class="far fa-arrow-right" aria-hidden="true"></i>
                    </button>
                @else
                    <span class="page-numbers disabled" aria-disabled="true" aria-label="Next page">
                        <i class="far fa-arrow-right" aria-hidden="true"></i>
                    </span>
                @endif
            </li>
        </ul>
    </nav>
@endif
