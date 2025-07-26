@php
    $color = $deleting ? 'danger' : 'primary';
    $action = $deleting ? 'deleted' : ($editing ? 'update' : 'store');
    $actionText = $deleting ? 'Hapus' : ($editing ? 'Edit' : 'Tambah');
    $title = $editing ? 'Edit Pengguna' : 'Tambah Pengguna';
    $required = $editing ? false : true;
    $isDeleting = $deleting ? false : true; // Show header only when not deleting
@endphp

<x-modal id="modal-user" :title="$title" :show-header="$isDeleting" :centered="$isDeleting">
    @if ($deleting) <!-- Deleting state -->
        Apakah Anda yakin ingin menghapus pengguna dengan email <b>{{ $email }}</b>?
    @else
        <x-input label="Nama" wire:model="name" :required="$required"
            placeholder="Masukkan nama pengguna" :error="$errors->first('name')" />

        <x-input type="email" label="Email" wire:model="email" :required="$required"
            placeholder="Masukkan email pengguna" :error="$errors->first('email')" />

        <x-select label="Peran" wire:model="role_id" :required="$required"
            placeholder="Pilih peran pengguna" :error="$errors->first('role_id')" :options="$roles" />

        @if (!$editing) <!-- Only show password fields when creating a new user -->
            <x-input type="password" label="Kata Sandi" wire:model="password" :required="$required"
                placeholder="Masukkan kata sandi pengguna" :error="$errors->first('password')" />

            <x-input type="password" label="Konfirmasi Kata Sandi" wire:model="password_confirmation"
                :required="$required" placeholder="Konfirmasi kata sandi pengguna"
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
        const target = document.getElementById('modal-user');
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
