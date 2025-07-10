@props([
    'label' => null,
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'error' => null,
    'min' => null,
    'max' => null,
    'append' => false,
    'prepend' => false,
    'readonly' => false,
])

@php
    use Illuminate\Support\Str;

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

    <div class="input-group">
        @if ($prepend)
            <span class="input-group-text">
                {{ $prepend }}
            </span>
        @endif

        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            @if ($type === 'number' && $min !== null) min="{{ $min }}" @endif
            @if ($type === 'number' && $max !== null) max="{{ $max }}" @endif
            {{ $attributes->class([
                'form-control',
                $error ? 'is-invalid' : '',
            ]) }}
        >

        @if($append)
            <span class="input-group-text">
                {{ $append }}
            </span>
        @endif
    </div>

    @if ($error)
        <div class="invalid-feedback d-block">
            {{ $error }}
        </div>
    @endif
</div>
