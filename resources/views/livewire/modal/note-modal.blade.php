<x-modal id="modal-note" :title="'Catatan untuk ' . $status_format">
    <x-textarea label="Catatan" wire:model="note" rows="3" :required="true"
        placeholder="Silakan masukkan catatan agar pelanggan mengetahui alasan penolakan atau verifikasi pembayaran."
        :error="$errors->first('note')" />

    <x-slot name="actions">
        <x-button color="primary" action="submit" target="submit">
            Submit
        </x-button>
    </x-slot>
</x-modal>

@script
    <script>
        const target = document.getElementById('modal-note');
        const modal = new bootstrap.Modal(target, {
            backdrop: 'static',
            keyboard: false
        });

        Livewire.on('modal:show', () => { modal.show() });
        Livewire.on('modal:hide', () => { modal.hide() });

        target.addEventListener('hidden.bs.modal', () => {
            Livewire.dispatch('modal:onreset');
        });

        target.addEventListener('shown.bs.modal', () => {
            const textarea = target.querySelector('textarea');
            if (textarea) {
                textarea.focus();
            }
        });
    </script>
@endscript
