<div class="card">
    <div class="card-header">
        Upload Bukti Pembayaran
    </div>

    <div class="card-body">
        <p>
            Silakan upload bukti pembayaran Anda untuk menyelesaikan transaksi ini. Pastikan file yang diunggah
            sesuai dengan format yang diterima.
        </p>

        <x-file-upload label="Bukti Pembayaran" wire:model="proof_file"
            accept="image/jpeg,image/jpg,image/png,application/pdf"
            margin="mb-0"
            :error="$errors->first('proof_file')" />
    </div>

    <div class="card-footer flex justify-end gap-2">
        <x-button color="secondary" action="previousStep" target="previousStep">
            Kembali
        </x-button>

        <x-button color="success" action="submit" target="submit" class="text-white">
            Kirim & Selesai
        </x-button>
    </div>
</div>
