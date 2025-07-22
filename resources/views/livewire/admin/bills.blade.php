<div>
    @include('livewire.admin.bills.widget')

    <div class="row my-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <x-spinner target="edit, destroy, search, perPage, filterStatus" />
                        Data Tagihan
                    </div>

                    <button wire:click="$dispatch('customer:create')" class="btn btn-primary btn-sm">
                        Tambah
                    </button>
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

                            <select class="form-select" wire:model.change="filterStatus">
                                <option value="">Semua</option>
                                <option value="waiting">Menunggu Konfirmasi</option>
                                <option value="unpaid">Belum Dibayar</option>
                                <option value="paid">Lunas</option>
                            </select>
                        </div>

                        <div>
                            <input type="text" class="w-[300px] form-control" placeholder="Cari Tagihan..."
                                wire:model.live.debounce.500ms="search">
                        </div>
                    </div>

                    <x-dash.table headers="No, Pelanggan, Periode, Pemakaian, Tarif, Total, Jatuh Tempo, Status,  ">
                        @forelse ($bills as $bill)

                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data tagihan</td>
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
