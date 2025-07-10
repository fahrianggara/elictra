@props([
    'label' => null,
    'placeholder' => 'Pilih salah satu',
    'required' => false,
    'error' => null,
    'options' => [], // ['value' => 'Label']
    'margin' => 'mb-3',
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

<div class="{{ $margin }}">
    {{-- If the name is not set, we cannot render the select --}}
    @if ($label)
        <label for="{{ $id }}" class="form-label {{ $required ? 'required' : '' }}">
            {{ $label }}
        </label>
    @endif

    <select
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->class([
            'form-select',
            $error ? 'is-invalid' : '',
        ]) }}
    >
        <option value="" disabled selected hidden>{{ $placeholder }}</option>

        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
        @endforeach
    </select>

    @if ($error)
        <div class="invalid-feedback d-block">
            {{ $error }}
        </div>
    @endif
</div>
