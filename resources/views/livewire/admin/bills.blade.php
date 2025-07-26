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

                    <x-dash.table headers="No, Pelanggan, Tarif, Periode, Pemakaian, Total Biaya & Invoice, Jatuh Tempo, Status,  ">
                        @forelse ($bills as $bill)
                            <tr>
                                <td>{{ $bills->firstItem() + $loop->index }}</td>
                                <td>
                                    {{ $bill->customer->user->name }}
                                    <p class="mb-0 text-muted">{{ $bill->customer->meter_number }}</p>
                                </td>
                                <td>{{ $bill->customer->tarif->format_tarif }}</td>
                                <td>{{ formatPeriod($bill->period) }}</td>
                                <td>{{ $bill->usage }} kWh</td>
                                <td>
                                    {{ rupiah($bill->amount) }}
                                    <p class="mb-0 text-muted">#{{ $bill->invoice }}</p>
                                </td>
                                <td>{{ formatDate($bill->due_date, 'l, d F Y') }}</td>
                                <td>
                                    <p class="d-inline-flex px-2 mb-0 py-1 text-[14px] fw-semibold border rounded-2 {{ $bill->color }}">
                                        {{ $bill->status_format }}
                                    </p>
                                </td>
                                <td>
                                    <x-dash.table-action>
                                        @if($bill->status != 'paid')
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    wire:click="$dispatch('bill:edit', { id: '{{ encrypt($bill->id) }}' })">
                                                    <i class="fas fa-edit text-warning mr-2"></i>
                                                    Edit
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0)"
                                                    wire:click="$dispatch('bill:delete', { id: '{{ encrypt($bill->id) }}' })">
                                                    <i class="fas fa-trash-alt text-danger mr-2"></i>
                                                    Hapus
                                                </a>
                                            </li>
                                        @endif

                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                wire:click="$dispatch('bill:show', { id: '{{ encrypt($bill->id) }}' })">
                                                <i class="fas fa-external-link-alt text-info mr-2"></i>
                                                Detail
                                            </a>
                                        </li>
                                    </x-dash.table-action>
                                </td>
                            </tr>
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
