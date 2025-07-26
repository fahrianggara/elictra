<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <x-spinner target="edit, destroy, search, perPage, filterTarif, filterStatus" />
                        Data Pelanggan
                    </div>

                    <button wire:click="$dispatch('customer:create')" class="btn btn-primary btn-sm">
                        Tambah
                    </button>
                </div>

                <div class="card-body">
                    <div class="row mb-3 gap-2 justify-content-between align-items-center">
                        <div class="col-md-6 flex gap-2">
                            <x-select wire:model.change="perPage" placeholder="Tampilkan"
                                class="w-[80px]"
                                margin="mb-0" :options="[
                                    10 => '10',
                                    25 => '25',
                                    50 => '50',
                                    100 => '100',
                                ]" />

                            <x-select wire:model.change="filterTarif" placeholder="Tarif Listrik"
                                margin="mb-0" :options="$tarifs" showAll allLabel="Semua Tarif" />

                            <x-select wire:model.change="filterStatus" placeholder="Status Pelanggan"
                                margin="mb-0" :options="[
                                    'all' => 'Semua',
                                    0 => 'Aktif',
                                    1 => 'Terblokir',
                                ]" />
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Cari Pelanggan..."
                                wire:model.live.debounce.500ms="search">
                        </div>
                    </div>

                    <x-dash.table headers="No, Nama & Email, Alamat, Tarif Listrik, No. Meteran, Berlangganan Pada, Status, ">
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ $customers->firstItem() + $loop->index }}</td>
                                <td>
                                    {{ $customer->user->name }}
                                    <p class="mb-0 text-muted">{{ $customer->user->email }}</p>
                                </td>
                                <td >{{ $customer->address }}</td>
                                <td class="w-[140px]">
                                    {{ $customer->tarif?->format_tarif }}
                                </td>
                                <td>
                                    {{ $customer->meter_number }}
                                </td>
                                <td class="w-[200px]">
                                    {{ $customer->created_at->translatedFormat('l, d F Y') }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $customer->is_blocked ? 'danger' : 'success' }}">
                                        {{ $customer->is_blocked ? 'Terblokir' : 'Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <x-dash.table-action>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                wire:click="$dispatch('customer:edit', { id: '{{ encrypt($customer->id) }}' })">
                                                <i class="fas fa-edit text-warning mr-2"></i>
                                                Edit
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                wire:click="$dispatch('customer:delete', { id: '{{ encrypt($customer->id) }}' })">
                                                <i class="fas fa-trash-alt text-danger mr-2"></i>
                                                Hapus
                                            </a>
                                        </li>
                                    </x-dash.table-action>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data pelanggan</td>
                            </tr>
                        @endforelse
                    </x-dash.table>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted text-[15px]">
                            Menampilkan {{ $customers->count() }} dari {{ $customers->total() }} data
                        </div>
                        {{ $customers->links('components.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('modal.customer-modal', [
        'tarifs' => $tarifs
    ])
</div>
