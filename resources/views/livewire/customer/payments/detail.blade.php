<div class="card">
    <div class="card-header">
        Detail Tagihan Kamu
    </div>

    <div class="card-body">
        <p class="">
            Periksa dengan teliti detail tagihan kamu sebelum melanjutkan ke langkah berikutnya.
        </p>

        <div class="table-responsive">
            <div class="rounded border py-2 px-3">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Invoice</td>
                        <td>#1203102301203103</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nama Pelanggan</td>
                        <td>Fahri Anggara</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nomor kWh</td>
                        <td>1234567890</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Periode</td>
                        <td>Januari 2023</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jumlah Meter</td>
                        <td>200 kWh</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tarif per kWh</td>
                        <td>Rp1500</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Metode Pembayaran</td>
                        <td>Bank BCA</td>
                    </tr>
                    <tr>
                        <td class="pb-3 text-muted">Biaya Admin</td>
                        <td class="pb-3">Rp2500</td>
                    </tr>
                    <tr style="border-top: 1px solid #e3e3e3;">
                        <th class="py-3" style="font-size: 17px">Total Tagihan</th>
                        <td class="py-3 text-2xl fw-bold text-primary">Rp300000</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer flex justify-end gap-2">
        <x-button color="secondary" action="previousStep" target="previousStep">
            Kembali
        </x-button>

        <x-button color="primary" action="nextStep" target="nextStep">
            Lanjutkan
        </x-button>
    </div>
</div>
