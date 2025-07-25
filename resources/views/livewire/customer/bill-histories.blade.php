<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <x-spinner target="search, perPage, filterStatus, modalShow" />
                        Riwayat Tagihan
                    </div>
                </div>

                <div class="card-body">
                    <div class="flex justify-between gap-2 mb-3">
                        <div class="flex items-center gap-2">
                            <x-select wire:model.change="perPage" placeholder="Tampilkan"
                                class="w-[80px]"
                                margin="mb-0" :options="[
                                    10 => '10',
                                    25 => '25',
                                    50 => '50',
                                    100 => '100',
                                ]" />

                            <x-select wire:model.change="filterStatus" placeholder="Status Pembayaran"
                            margin="mb-0" :options="[
                                'all' => 'Semua',
                                'pending' => 'Menunggu Verifikasi',
                                'verified' => 'Terverifikasi',
                                'rejected' => 'Ditolak',
                            ]" />
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Cari Riwayat..."
                                wire:model.live.debounce.500ms="search">
                        </div>
                    </div>

                    <x-dash.table
                        headers="No,  Invoice, Bukti, Periode, Total Bayar, Tanggal Pembayaran, Status, Catatan, ">
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payments->firstItem() + $loop->index }}</td>
                                <td>#{{ $payment->bill->invoice }}</td>
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
                                <td>{{ formatPeriod($payment->bill->period) }}</td>
                                <td>{{ rupiah($payment->amount) }}</td>
                                <td>
                                    {{ formatDate($payment->created_at, 'd F Y') }}
                                </td>
                                <td>
                                    <p
                                        class="d-inline-flex px-2 mb-0 py-1 text-[14px] fw-semibold border rounded-2 {{ $payment->color }}">
                                        {{ $payment->status_format }}
                                    </p>
                                </td>
                                <td style="max-width: 280px;">
                                    {{ "\"$payment->note\"" ?? '-' }}
                                </td>
                                <td>
                                    @if ($payment->is_reupload)
                                        <button type="button" data-coreui-toggle="tooltip"
                                            data-coreui-placement="top"
                                            data-coreui-title="Unggah Ulang Bukti"
                                            wire:click="modalShow('{{ encrypt($payment->id) }}')"
                                            class="btn btn-sm btn-warning text-white">
                                            <i class="fas fa-upload"></i>
                                        </button>
                                    @else
                                        <button type="button"
                                            data-coreui-toggle="tooltip"
                                            data-coreui-placement="top"
                                            data-coreui-title="Cetak Invoice"
                                            href="#" {{ $payment->status != 'verified' ? 'disabled' : '' }}
                                            class="btn btn-sm btn-success text-white">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Anda tidak memiliki riwayat tagihan saat ini.
                                </td>
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

    @include('livewire.modal.proof-modal')
</div>
