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
        <x-spinner target="{{ $target }}" class="me-1 align-middle" />
    @endif

    {{-- Icon tetap ditampilkan --}}
    @if ($icon)
        <i class="{{ $icon }} me-1"></i>
    @endif

    {{ $slot }}
</button>
