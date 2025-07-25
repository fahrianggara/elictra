<x-modal id="modal-proof" title="Unggah Ulang Bukti Pembayaran">
    <x-file-upload
        label="Bukti Pembayaran"
        wire:model="proof_file"
        accept="image/jpeg,image/jpg,image/png,application/pdf"
        margin="mb-0"
        :error="$errors->first('proof_file')"
    />

    <x-slot name="actions">
        <x-button color="primary" action="submit" target="submit">
            Submit
        </x-button>
    </x-slot>
</x-modal>

@script
    <script>
        const target = document.getElementById('modal-proof');
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
