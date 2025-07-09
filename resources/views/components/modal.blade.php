<div id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true"
    wire:ignore.self {{ $attributes->merge(['class' => 'modal fade']) }}>
    <div class="modal-dialog {{ $size }} modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            @if ($showHeader)
                <div class="modal-header">
                    <p class="modal-title" id="{{ $id }}Label">{{ $title }}</p>
                </div>
            @endif

            <div class="modal-body">
                {{ $slot }}
            </div>

            <div class="modal-footer p-[5px]">
                <x-button color="secondary" action="close" target="close">
                    {{ $closeText }}
                </x-button>

                @isset($actions)
                    {{ $actions }}
                @endisset
            </div>
        </div>
    </div>
</div>
