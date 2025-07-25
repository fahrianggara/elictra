<x-modal id="modal-logout" :show-header="false" :centered="false" action="">
    <p class="mb-0">
        Apakah anda yakin ingin keluar dari {{ config('app.name') }} ?
    </p>

    <x-slot name="actions">
        <x-button color="danger" action="logout" target="logout"
            class="text-white ">
            Ya, Keluar
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

        Livewire.on('logout:hide', () => {
            modal.hide();
        });
    </script>
@endscript
