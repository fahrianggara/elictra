<div class="card">
    <div class="card-header">
        Ringkasan Tagihan Listrik
    </div>

    <div class="card-body">
        <p class="">
            Gunakan informasi berikut untuk menyelesaikan pembayaran tagihan listrik kamu.
        </p>

        <div class="table-responsive">
            <div class="rounded border py-2 px-3">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Invoice</td>
                        <td>#{{ $bill->invoice }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nama Pelanggan</td>
                        <td>{{ $bill->customer->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nomor kWh</td>
                        <td>{{ $bill->customer->meter_number }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Periode</td>
                        <td>{{ formatPeriod($bill->period) }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Meter Awal</td>
                        <td>{{ $bill->meter_start }} kWh</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Meter Akhir</td>
                        <td>{{ $bill->meter_end }} kWh</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jumlah Pemakaian</td>
                        <td>{{ $bill->usage }} kWh</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Metode Pembayaran</td>
                        <td>{{ $payment_method->name }}</td>
                    </tr>
                    <tr>
                        <td class=" text-muted">Jatuh Tempo</td>
                        <td class="">
                            {{ formatDate($bill->due_date, 'l, d F Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tarif</td>
                        <td>{{ $bill->customer->tarif->format_tarif }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tarif per kWh</td>
                        <td>{{ rupiah($bill->customer->tarif->price_per_kwh) }}</td>
                    </tr>
                    <tr>
                        <td class=" text-muted">Biaya Admin</td>
                        <td class="">
                            {{ rupiah($payment_method->fee) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-3 text-muted">Tagihan</td>
                        <td class="pb-3">
                            {{ rupiah($bill->amount) }}
                            <p class="text-muted mb-0">
                                (Meter Akhir - Meter Awal) x Tarif per kWh
                            </p>
                        </td>
                    </tr>
                    <tr style="border-top: 1px solid #e3e3e3;">
                        <th class="py-3" style="font-size: 17px">Total Keseluruhan</th>
                        <td class="py-3 text-2xl fw-bold text-primary">
                            {{ rupiah($total) }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <p class="mt-4 mb-0">
            Silakan salin nomor {{ strtolower($payment_method->label) }} di bawah untuk melakukan pembayaran.
            Pastikan jumlah yang ditransfer sesuai dengan Total Tagihan di atas.
        </p>

        <div x-data="{ copied: false }" class="d-flex align-items-center justify-between border p-3 rounded mt-2">
            <div class="me-3">
                <div class="text-muted mb-1">{{ $payment_method->label }}</div>
                <div class="fw-semibold fs-5">{{ $payment_method->number }}</div>
            </div>

            <button
                class="btn btn-outline-primary btn-sm"
                x-on:click="navigator.clipboard.writeText('{{ $payment_method->number }}'); copied = true; setTimeout(() => copied = false, 2000)"
            >
                <template x-if="!copied">
                    <span>Salin</span>
                </template>
                <template x-if="copied">
                    <span>Nomor Disalin!</span>
                </template>
            </button>
        </div>

        <div class="alert alert-warning mb-0 mt-3">
            Jangan lupa untuk menyimpan bukti pembayaran setelah melakukan transfer.
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
