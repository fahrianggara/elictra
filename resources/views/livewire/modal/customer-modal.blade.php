<x-modal id="modal-costumer" title="Tambah Pelanggan" class="show d-block">
    <x-input label="Nama" wire:model="name" :required="true"
        placeholder="Masukkan nama pelanggan" :error="$errors->first('name')" />

    <x-input type="email" label="Email" wire:model="email" :required="true"
        placeholder="Masukkan email pelanggan" :error="$errors->first('email')" />

    <x-input type="number" label="No Meteran" wire:model="meter_number" :required="true"
        min="0" max="9999999999" placeholder="Masukkan nomor meteran pelanggan"
        :error="$errors->first('meter_number')" />

    <x-input type="number" label="Meter Awal" wire:model="initial_meter" :required="true"
        placeholder="Masukkan meter listik awalannya berapa" min="0" max="9999999999"
        :error="$errors->first('initial_meter')" />

    <x-textarea label="Alamat" wire:model="address" rows="4" :required="true"
        placeholder="Masukkan alamat pengguna" :error="$errors->first('address')" />

    <x-slot name="actions">
        <x-button color="primary" action="store" target="store">
            Simpan
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

        Livewire.on('modal:show', () => {
            modal.show();
        });

        Livewire.on('modal:hide', () => {
            modal.hide();
        });
    </script>
@endscript
