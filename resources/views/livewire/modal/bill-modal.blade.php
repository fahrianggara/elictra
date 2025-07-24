@php
    $color = $deleting ? 'danger' : 'primary';
    $action = $deleting ? 'deleted' : ($editing ? 'update' : 'store');
    $actionText = $deleting ? 'Hapus' : ($editing ? 'Edit' : 'Tambah');
    $title = $editing ? 'Edit Tagihan' : 'Tambah Tagihan';
    $required = $editing ? false : true;
    $isDeleting = $deleting ? false : true; // Show header only when not deleting
@endphp

<x-modal id="modal-bill" :title="$title" :show-header="$isDeleting" :centered="$isDeleting">
    @if ($deleting) <!-- Deleting state -->
        Apakah Anda yakin ingin menghapus tagihan untuk pelanggan <strong>{{ $customer->name }}</strong> pada periode <strong>{{ $period }}</strong>?
    @else
        <x-select label="Pelanggan" wire:model="customer_id" :required="$required"
            placeholder="Pilih pelanggan" :error="$errors->first('customer_id')" :options="$customers"/>

        <x-input label="Periode" wire:model="period" type="month" :required="$required"
            placeholder="Pilih periode" :error="$errors->first('period')" />
    @endif

    <x-slot name="actions">
        <x-button :color="$color" :action="$action" target="store, update, deleted"
            class="{{ $deleting ? 'text-white' : '' }}">
            {{ $actionText }}
        </x-button>
    </x-slot>
</x-modal>

@script
    <script>
        const target = document.getElementById('modal-bill');
        const modal = new bootstrap.Modal(target, {
            backdrop: 'static',
            keyboard: false
        });

        Livewire.on('modal:show', () => { modal.show() });
        Livewire.on('modal:hide', () => { modal.hide() });

        target.addEventListener('hidden.bs.modal', () => {
            Livewire.dispatch('modal:onreset');
        });
    </script>
@endscript
