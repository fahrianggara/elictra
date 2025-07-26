<div>
    @include('livewire.admin.payments.widget')

    <div class="row my-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <x-spinner target="edit, destroy, search, perPage, filterStatus, modalShow" />
                        Data Pembayaran
                    </div>
                </div>
                <div class="card-body">
                    @include('livewire.admin.payments.filter')

                    <x-dash.table headers="No, Pelanggan, Periode, Metode Pembayaran, Total Biaya, Bukti Pembayaran, Tanggal, Status, Aksi">
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payments->firstItem() + $loop->index }}</td>
                                <td>
                                    {{ $payment->bill->customer->user->name }}
                                    <p class="mb-0 text-muted">{{ $payment->bill->customer->meter_number }}</p>
                                </td>
                                <td>{{ formatPeriod($payment->bill->period) }}</td>
                                <td>{{ $payment->method->name }}</td>
                                <td>{{ rupiah($payment->amount) }}</td>
                                <td>
                                    @if (checkFile($payment->proof_file))
                                        <a href="{{ getFile($payment->proof_file) }}" target="_blank"
                                            class="text-blue-500 hover:underline">
                                            Lihat Bukti
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ formatDate($payment->created_at, 'l, d F Y H:i') }}</td>
                                <td>
                                    <p class="d-inline-flex px-2 mb-0 py-1 text-[14px] fw-semibold border rounded-2 {{ $payment->color }}">
                                        {{ $payment->status_format }}
                                    </p>
                                </td>
                                <td>
                                    @if ($payment->status == 'pending')
                                        <button type="button" data-coreui-toggle="tooltip"
                                            data-coreui-title="Verifikasi Pembayaran"
                                            wire:click="modalShow('{{ encrypt($payment->id) }}', 'verified')"
                                            class="btn btn-sm btn-success text-white w-8 h-8">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        <button type="button" data-coreui-toggle="tooltip"
                                            data-coreui-title="Tolak Pembayaran"
                                            wire:click="modalShow('{{ encrypt($payment->id) }}', 'rejected')"
                                            class="btn btn-sm btn-danger text-white w-8 h-8">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @elseif ($payment->status == 'rejected')
                                        <button type="button" disabled
                                            class="btn btn-sm btn-success text-white w-8 h-8">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        <button type="button" disabled
                                            class="btn btn-sm btn-danger text-white w-8 h-8">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @else
                                        <a data-coreui-toggle="tooltip" data-coreui-placement="top"
                                            data-coreui-title="Cetak Invoice"
                                            href="{{ route('print.bill', encrypt($payment->id)) }}"
                                            :disabled="$payment->status != 'verified'"
                                            class="btn btn-sm btn-success text-white">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Tidak ada data pembayaran</td>
                            </tr>
                        @endforelse
                    </x-dash.table>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted text-[15px]">
                            Menampilkan {{ $payments->count() }} dari {{ $payments->total() }} data
                        </div>
                        {{ $payments->links('components.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.modal.note-modal')
</div>
