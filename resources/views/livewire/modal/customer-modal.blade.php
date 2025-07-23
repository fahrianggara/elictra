@php
    $color = $deleting ? 'danger' : 'primary';
    $action = $deleting ? 'deleted' : ($editing ? 'update' : 'store');
    $actionText = $deleting ? 'Hapus' : ($editing ? 'Edit' : 'Tambah');
    $title = $editing ? 'Edit Pelanggan' : 'Tambah Pelanggan';
    $required = $editing ? false : true;
    $isDeleting = $deleting ? false : true; // Show header only when not deleting
@endphp

<x-modal id="modal-costumer" :title="$title" :show-header="$isDeleting" :centered="$isDeleting">
    @if ($deleting) <!-- Deleting state -->
        Apakah Anda yakin ingin menghapus pelanggan dengan nama <strong>{{ $name }}</strong>?
    @else
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
            placeholder="Masukkan alamat pelanggan" :error="$errors->first('address')" />

        @if (!$editing) <!-- Only show password fields when creating a new user -->
            <x-input type="password" label="Kata Sandi" wire:model="password" :required="$required"
                placeholder="Masukkan kata sandi pelanggan" :error="$errors->first('password')" />

            <x-input type="password" label="Konfirmasi Kata Sandi" wire:model="password_confirmation"
                :required="$required" placeholder="Konfirmasi kata sandi pelanggan"
                :error="$errors->first('password_confirmation')" />
        @endif
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
        const target = document.getElementById('modal-costumer');
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
