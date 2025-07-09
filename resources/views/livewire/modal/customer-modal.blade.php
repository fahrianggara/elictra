<x-modal id="modal-costumer" title="Tambah Pelanggan">
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
