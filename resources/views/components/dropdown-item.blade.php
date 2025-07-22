@props([
    'href' => '#',
    'icon' => null,
    'action' => null,
    'target' => null,
])

@php
    // Jika tidak ada target, gunakan action sebagai default target
    $wireTarget = $target ?? $action;
@endphp

<li>
    <a
        href="{{ $href }}"
        class="dropdown-item"
        @if ($action) wire:click="{{ $action }}" @endif
        @if ($wireTarget) wire:target="{{ $wireTarget }}" @endif
        wire:loading.attr="disabled"
    >
        @if ($icon)
            <i class="{{ $icon }} me-2"></i>
        @endif
        {{ $slot }}
    </a>
</li>
