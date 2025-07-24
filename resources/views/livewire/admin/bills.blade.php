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

                    <button wire:click="$dispatch('bill:create')" class="btn btn-primary btn-sm">
                        Tambah
                    </button>
                </div>

                <div class="card-body">
                    @include('livewire.admin.bills.filter')

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

    @livewire('modal.bill-modal', [
        'customers' => $customers
    ])
</div>
