<div>
    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card mb-3">
                @include('livewire.customer.payments.nav')
            </div>

            @if ($step_current == 1)
                @include('livewire.customer.payments.method')
            @endif

            @if ($step_current == 2)
                @include('livewire.customer.payments.detail')
            @endif

            @if ($step_current == 3)
                @include('livewire.customer.payments.upload')
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Cara Pembayaran
                </div>
                <div class="card-body">
                    Ikuti petunjuk berikut untuk melakukan pembayaran tagihan Anda:
                    <ol class="list-decimal list-outside mt-3 px-3 d-flex flex-col gap-2">
                        <li>
                            Pilih metode pembayaran yang Anda inginkan, seperti transfer bank atau e-wallet.
                        </li>
                        <li>
                            Sesuaikan jumlah pembayaran dengan total tagihan yang tertera. Pastikan Anda tidak salah
                            memasukkan nomor rekening atau akun tujuan.
                        </li>
                        <li>
                            Pastikan semua data yang dimasukkan sudah benar sebelum mengonfirmasi pembayaran.
                        </li>
                        <li>
                            Setelah pembayaran berhasil, simpan bukti pembayaran sebagai referensi, lalu unggah bukti
                            pembayaran di halaman ini.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
