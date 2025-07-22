@props([
    'label' => 'Upload File',
    'accept' => 'image/png',
    'required' => false,
    'error' => null,
    'src' => null,
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

<div
    x-data="{ uploading: false, progress: 0 }"
    x-on:livewire-upload-start="uploading = true"
    x-on:livewire-upload-finish="uploading = false"
    x-on:livewire-upload-cancel="uploading = false"
    x-on:livewire-upload-error="uploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>
    @if ($src)
        <div class="w-full flex items-center justify-center bg-gray-100 rounded-lg p-2 mb-3">
            <img src="{{ $src }}" alt="Preview Image" class="h-[100px] object-cover rounded-lg">
        </div>
    @endif

    <div x-show="uploading" class="mb-2">
        <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
            <div
                class="bg-blue-500 h-2.5 rounded-full transition-all duration-300 ease-in-out"
                x-bind:style="'width: ' + progress + '%'">
            </div>
        </div>
        <div class="text-sm text-gray-600 mt-1" x-text="'Mengunggah... ' + progress + '%'"></div>
    </div>

    <div class="mb-3">
        @if ($label)
            <label for="{{ $id }}" class="form-label {{ $required ? 'required' : '' }}">
                {{ $label }}
            </label>
        @endif

        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="file"
            accept="{{ $accept }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->class([
                'form-control',
                $error ? 'is-invalid' : '',
            ]) }}
        >

        @if ($error)
            <div class="invalid-feedback d-block">
                {{ $error }}
            </div>
        @else
            <div class="form-text">Format gambar: PNG. Maksimal ukuran: 5MB.</div>
        @endif
    </div>
</div>
