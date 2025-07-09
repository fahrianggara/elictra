@props([
    'type' => 'button',
    'color' => 'primary',
    'class' => '',
    'action' => null,
    'target' => null,
    'icon' => null,
])

<button type="{{ $type }}" class="btn btn-{{ $color }} {{ $class }}"
    @if ($action) wire:click="{{ $action }}" @endif
    @if ($target) wire:target="{{ $target }}" @endif wire:loading.attr="disabled">
    {{-- Spinner saat loading --}}
    @if ($target)
        <span class="spinner-border spinner-border-sm me-1 align-middle" wire:loading wire:target="{{ $target }}"
            role="status" aria-hidden="true"></span>
    @endif

    {{-- Icon tetap ditampilkan --}}
    @if ($icon)
        <i class="{{ $icon }} me-1"></i>
    @endif

    {{ $slot }}
</button>
