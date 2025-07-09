@php
    $action = $editing ? 'update' : 'store';
    $actionText = $editing ? 'Edit' : 'Tambah';
    $title = $editing ? 'Edit Pelanggan' : 'Tambah Pelanggan';
    $required = $editing ? false : true;
@endphp

<x-modal id="modal-costumer" :title="$title" >
    <x-input label="Nama" wire:model="name" :required="$required"
        placeholder="Masukkan nama pelanggan" :error="$errors->first('name')" />

    <x-input type="email" label="Email" wire:model="email" :required="$required"
        placeholder="Masukkan email pelanggan" :error="$errors->first('email')" />

    <x-input type="number" label="No Meteran" wire:model="meter_number" :required="$required"
        min="0" max="9999999999" placeholder="Masukkan nomor meteran pelanggan"
        :error="$errors->first('meter_number')" />

    <x-input type="number" label="Meter Awal" wire:model="initial_meter" :required="$required"
        placeholder="Masukkan meter listik awalannya berapa" min="0" max="9999999999"
        :error="$errors->first('initial_meter')" />

    <x-select label="Tarif Listrik" wire:model="tarif_id" :required="$required"
        :error="$errors->first('tarif_id')" :options="$tarifs"/>

    <x-textarea label="Alamat" wire:model="address" rows="4" :required="$required"
        placeholder="Masukkan alamat pengguna" :error="$errors->first('address')" />

    <x-slot name="actions">
        <x-button color="primary" :action="$action" target="store, update">
            {{ $actionText }}
        </x-button>
    </x-slot>
</x-modal>

@script
    <script>
        const target = document.getElementById('modal-costumer');
        const modal = new bootstrap.Modal(target, {
            backdrop: 'static',
            keyboard: false
        });

        Livewire.on('modal:show', () => { modal.show() });
        Livewire.on('modal:hide', () => { modal.hide() });
    </script>
@endscript
