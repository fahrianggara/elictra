<div>
    <div class="card">
        <div class="card-header">
            Pembayaran Pending
        </div>
        <div class="card-body">
            @if ($payments->isEmpty())
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    Tidak ada pembayaran yang perlu diverifikasi.
                </div>
            @else
                <x-dash.table headers="Invoice, Pelanggan, Periode, Total Bayar, Bukti, Aksi">
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->bill->invoice }}</td>
                            <td>{{ $payment->bill->customer->user->name }}</td>
                            <td>{{ formatPeriod($payment->bill->period) }}</td>
                            <td>{{ rupiah($payment->amount) }}</td>
                            <td>
                                @if (checkFile($payment->proof_file))
                                    <a href="{{ getFile($payment->proof_file) }}" target="_blank"
                                        class="text-blue-500 hover:underline">
                                        Lihat
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <button type="button" data-coreui-toggle="tooltip" data-coreui-title="Verifikasi Pembayaran"
                                    wire:click="modalShow('{{ encrypt($payment->id) }}', 'verified')"
                                    class="btn btn-sm btn-success text-white w-8 h-8">
                                    <i class="fas fa-check"></i>
                                </button>

                                <button type="button" data-coreui-toggle="tooltip" data-coreui-title="Tolak Pembayaran"
                                    wire:click="modalShow('{{ encrypt($payment->id) }}', 'rejected')"
                                    class="btn btn-sm btn-danger text-white w-8 h-8">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </x-dash.table>
            @endif
        </div>
    </div>

    @include('livewire.modal.note-modal')
</div>
