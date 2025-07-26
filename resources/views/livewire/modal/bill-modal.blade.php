@php
    $color = $deleting ? 'danger' : ($showing ? 'info' : 'primary');
    $action = $deleting ? 'deleted' : ($editing ? 'update' : ($showing ? 'show' : 'store'));
    $actionText = $deleting ? 'Hapus' : ($editing ? 'Edit' : ($showing ? 'Lihat' : 'Tambah'));
    $title = $deleting ? 'Hapus Tagihan' : ($editing ? 'Edit Tagihan' : ($showing ? 'Detail Tagihan' : 'Tambah Tagihan'));
    $required = ($editing || $showing) ? false : true;
    $isDeleting = $deleting ? false : true; // Show header only when not deleting
@endphp

<x-modal id="modal-bill" :title="$title" :show-header="$isDeleting" :centered="$isDeleting"
    spinnerTarget="store, update, customer_id, usage, period">

    @if ($deleting) <!-- Deleting state -->
        Apakah Anda yakin ingin menghapus tagihan untuk pelanggan <strong>{{ $customerInfo->user->name }}</strong> pada periode
        <strong>{{ $period }}</strong> dengan pemakaian <strong>{{ $usage }} kWh</strong>?
    @elseif ($showing) <!-- Showing state -->
        @include('livewire.modal.bill.show')
    @else
        @if ($editing)
            @include('livewire.modal.bill.edit')
        @else {{-- CREATING --}}
            @include('livewire.modal.bill.create')
        @endif
    @endif

    @if(!$showing)
        <x-slot name="actions">
            <x-button :color="$color" :action="$action" target="store, update, deleted"
                class="{{ $deleting ? 'text-white' : '' }}">
                {{ $actionText }}
            </x-button>
        </x-slot>
    @endif
</x-modal>

@script
    <script>
        const target = document.getElementById('modal-bill');
        const modal = new bootstrap.Modal(target, {
            backdrop: 'static',
            keyboard: false
        });

        Livewire.on('modal:show', () => {
            modal.show()
        });
        Livewire.on('modal:hide', () => {
            modal.hide()
        });

        target.addEventListener('hidden.bs.modal', () => {
            Livewire.dispatch('modal:onreset');
        });
    </script>
@endscript
