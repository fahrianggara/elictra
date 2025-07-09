@props([
    'label' => null,
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'error' => null,
    'min' => null,
    'max' => null,
])

@php
    use Illuminate\Support\Str;

    // ambil wire:model agar bisa generate id/nama otomatis
    $model = collect($attributes->getAttributes())
        ->filter(fn($_, $key) => str_starts_with($key, 'wire:model'))
        ->keys()
        ->map(fn($key) => $attributes->get($key))
        ->first();

    $name = $model ? Str::afterLast($model, '.') : null;
    $id = $name ? Str::slug($name) : null;
@endphp

<div class="mb-3">
    @if ($label)
        <label for="{{ $id }}" class="form-label {{ $required ? 'required' : '' }}">
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        @if ($type === 'number' && $min !== null) min="{{ $min }}" @endif
        @if ($type === 'number' && $max !== null) max="{{ $max }}" @endif
        {{ $attributes->class([
            'form-control',
            $error ? 'is-invalid' : '',
        ]) }}
    >

    @if ($error)
        <div class="invalid-feedback d-block">
            {{ $error }}
        </div>
    @endif
</div>
