<div>
    @include('livewire.admin.payments.widget')

    <div class="row my-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <x-spinner target="edit, destroy, search, perPage, filterStatus" />
                        Data Pembayaran
                    </div>
                </div>
                <div class="card-body">
                    @include('livewire.admin.payments.filter')

                    <x-dash.table headers="No, Pelanggan, Periode, Metode Pembayaran & Jumlah, Bukti Pembayaran, Tanggal Pembayaran, Status, ">
                        @forelse ($payments as $payment)

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
</div>
