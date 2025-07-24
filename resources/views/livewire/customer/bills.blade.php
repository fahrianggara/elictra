<div>
    @if(count($bills) > 0)
        <div class="alert alert-warning mb-3">
            Silakan bayar tagihan Anda sebelum jatuh tempo untuk menghindari denda keterlambatan.
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        Tagihan Saya
                    </div>
                </div>

                <div class="card-body">
                    <div class="flex justify-between gap-2 mb-3">
                        <div class="flex items-center gap-2">
                            <select class="w-[80px] form-select" wire:model.change="perPage">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>

                    <x-dash.table headers="No,  Invoice, Periode, Pemakaian, Total Bayar, Status, Jatuh Tempo,  Aksi">
                        @forelse ($bills as $bill)
                            <tr>
                                <td>{{ $bills->firstItem() + $loop->index }}</td>
                                <td>#{{ $bill->invoice }}</td>
                                <td>{{ formatPeriod($bill->period) }}</td>
                                <td>{{ $bill->usage }} kWh</td>
                                <td>
                                    <p class="mb-0 font-bold text-[17px]">{{ rupiah($bill->amount) }}</p>
                                    <p class="mb-0 text-muted text-[15px]">(Belum Termasuk Biaya Admin)</p>
                                </td>
                                <td>
                                    <p class="d-inline-flex px-2 mb-0 py-1 text-[14px] fw-semibold border rounded-2 {{ $bill->color }}">
                                        {{ $bill->status_format }}
                                    </p>
                                </td>
                                <td>{{ formatDate($bill->due_date, 'l, d F Y') }}</td>
                                <td>
                                    @if ($bill->status == 'unpaid')
                                        <a href="{{ route('customer.payments', $bill->invoice) }}"
                                            class="btn btn-sm btn-success text-white rounded-2">
                                            Bayar Sekarang
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Anda tidak memiliki tagihan saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </x-dash.table>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted text-[15px]">
                            Menampilkan {{ $bills->count() }} dari {{ $bills->total() }} data
                        </div>
                        {{ $bills->links('components.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
