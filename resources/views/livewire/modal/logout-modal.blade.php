<x-modal id="modal-logout" :show-header="false" :centered="false" action="">
    <p>
        Apakah anda yakin ingin keluar dari sistem ?
    </p>

    <x-slot name="actions">
        <x-button color="danger" action="logout" target="logout"
            class="text-white ">
            <i class="fas fa-sign-out-alt me-1"></i> {{ __('Logout') }}
        </x-button>
    </x-slot>
</x-modal>

@script
    <script>
        const target = document.getElementById('modal-logout');
        const modal = new bootstrap.Modal(target, {
            backdrop: 'static',
            keyboard: false
        });

        Livewire.on('logout:show', () => {
            modal.show();
        });
    </script>
@endscript
