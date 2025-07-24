@props([
    'centered' => true,
    'action' => 'close',
    'spinnerTarget' => 'store, update',
])

<div id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true"
    wire:ignore.self {{ $attributes->merge(['class' => 'modal fade']) }}>
    <div class="modal-dialog {{ $size }} {{ $centered ? 'modal-dialog-centered modal-dialog-scrollable' : '' }}">
        <div class="modal-content">
            @if ($showHeader)
                <div class="modal-header">
                    <x-spinner :target="$spinnerTarget" class="me-2" />
                    <p class="modal-title" id="{{ $id }}Label">{{ $title }}</p>
                </div>
            @endif

            <div class="modal-body">
                {{ $slot }}
            </div>

            <div class="modal-footer p-[5px]">
                @if($action)
                    <x-button color="secondary" action="{{ $action }}" target="{{ $action }}">
                        {{ $closeText }}
                    </x-button>
                @else
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ $closeText }}</button>
                @endif

                @isset($actions)
                    {{ $actions }}
                @endisset
            </div>
        </div>
    </div>
</div>
