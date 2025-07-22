@php
    $color = $deleting ? 'danger' : 'primary';
    $action = $deleting ? 'deleted' : ($editing ? 'update' : 'store');
    $actionText = $deleting ? 'Hapus' : ($editing ? 'Edit' : 'Tambah');
    $title = $editing ? 'Edit Metode Pembayaran' : 'Tambah Metode Pembayaran';
    $required = $editing ? false : true;
    $isDeleting = $deleting ? false : true; // Show header only when not deleting
    $src = 'https://placehold.co/600x400?text=Logo';
    if (is_string($logo) && !empty($logo)) {
        $src = getFile($logo);
    } elseif ($logo && $logo->getFilename()) {
        $src = getFile("livewire-tmp/{$logo->getFilename()}");
    }
@endphp

<x-modal id="modal-metode-pembyaran" :title="$title" :show-header="$isDeleting" :centered="$isDeleting">
    @if ($deleting) <!-- Deleting state -->
        <p>Apakah Anda yakin ingin menghapus metode pembayaran ini?</p>
    @else
        <x-file-upload :src="$src" label="Logo" wire:model="logo" :required="$required"
            :error="$errors->first('logo')" />

        <x-select wire:model.change="type" label="Tipe Pembayaran" placeholder="Pilih tipe pembayaran" :options="[
            'bank_transfer' => 'Transfer Bank',
            'e_wallet' => 'Dompet Digital',
        ]" :required="$required" :error="$errors->first('type')" />

        <x-input label="Label" wire:model="label" readonly
            placeholder="Otomatis dari tipe pembayaran" :error="$errors->first('label')" />

        <x-input label="Nama" wire:model="name" :required="$required"
            placeholder="Masukkan nama metode pembayaran, cth: Bank BCA" :error="$errors->first('name')" />

        <x-input type="number" min="0" label="Biaya Admin" wire:model="fee" :required="$required"
            placeholder="Masukkan biaya admin, cth: 5000" :error="$errors->first('fee')" />

        <x-input type="number" min="0" label="Nomor Akun/Rekening" wire:model="number" :required="$required"
            placeholder="Masukkan harga nomor akun/rekening" :error="$errors->first('number')" />
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
        const target = document.getElementById('modal-metode-pembyaran');
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
