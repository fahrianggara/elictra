@props([
    'size' => 'sm',
    'target' => null,
    'class' => 'me-2', // Margin end class for spacing
])

<div class="spinner-border spinner-border-{{ $size }} {{ $class }}" role="status"
    @if($target) wire:loading wire:target="{{ $target }}" @endif>
    <span class="visually-hidden">Loading...</span>
</div>
