@php
    $color = $deleting ? 'danger' : 'primary';
    $action = $deleting ? 'deleted' : ($editing ? 'update' : 'store');
    $actionText = $deleting ? 'Hapus' : ($editing ? 'Edit' : 'Tambah');
    $title = $editing ? 'Edit Tarif Listrik' : 'Tambah Tarif Listrik';
    $required = $editing ? false : true;
    $isDeleting = $deleting ? false : true; // Show header only when not deleting
@endphp

<x-modal id="modal-tarif" :title="$title" :show-header="$isDeleting" :centered="$isDeleting">
    @if ($deleting) <!-- Deleting state -->
        Apakah Anda yakin ingin menghapus tarif dengan tipe & daya <b>{{ $type }} - {{ $power }}VA</b>?
    @else
        <x-input label="Tipe" wire:model="type" :required="$required"
            placeholder="Masukkan tipe tarif listrik" :error="$errors->first('type')" />

        <x-input type="number" min="0" label="Tenaga/Daya" wire:model="power" :required="$required" append="VA"
            placeholder="Masukkan tenaga atau daya" :error="$errors->first('power')" />

        <x-input type="number" min="0" label="Harga/kWh" wire:model="price_per_kwh" :required="$required" prepend="Rp"
            placeholder="Masukkan harga per kwh" :error="$errors->first('price_per_kwh')" />

        <x-input type="number" label="Denda/hari" wire:model="penalty_per_day" :required="$required" prepend="Rp"
            placeholder="Masukkan harga denda per hari" :error="$errors->first('penalty_per_day')" />

        <x-textarea label="Deskripsi" wire:model="description" rows="3" :required="$required"
            placeholder="Masukkan deskripsi tarif listrik" :error="$errors->first('description')" />
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
        const target = document.getElementById('modal-tarif');
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
