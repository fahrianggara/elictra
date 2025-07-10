<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <x-spinner target="edit, destroy, search, perPage, filterTarif, filterStatus" />
                        Data Tarif Listrik
                    </div>

                    <button wire:click="$dispatch('tarif:create')" class="btn btn-primary btn-sm">
                        Tambah Tarif Listrik
                    </button>
                </div>

                <div class="card-body">
                    <div class="row mb-3 gap-2 justify-content-between align-items-center">
                        <div class="col-md-6 flex gap-2">
                            <x-select wire:model.change="perPage" placeholder="Tampilkan" class="w-[80px]"
                                margin="mb-0" :options="[
                                    10 => '10',
                                    25 => '25',
                                    50 => '50',
                                    100 => '100',
                                ]" />
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Cari tarif listrik..."
                                wire:model.live.debounce.500ms="search">
                        </div>
                    </div>

                    <x-dash.table headers="No, Tipe & Daya, Deskripsi, Harga/kWh, Denda/Hari, Total Pelanggan, ">
                        @forelse ($tarifs as $tarif)
                            <tr>
                                <td>{{ $tarifs->firstItem() + $loop->index }}</td>
                                <td>{{ $tarif->type }} - {{ $tarif->power }}VA</td>
                                <td class="w-[600px]">{{ $tarif->description }}</td>
                                <td>{{ rupiah($tarif->price_per_kwh) }}</td>
                                <td>{{ rupiah($tarif->penalty_per_day) }}</td>
                                <td>{{ $tarif->customers_count }}</td>
                                <td>
                                    <x-dash.table-action>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                wire:click="$dispatch('tarif:edit', { id: '{{ encrypt($tarif->id) }}' })">
                                                <i class="fas fa-edit text-warning mr-2"></i>
                                                Edit
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                wire:click="$dispatch('tarif:delete', { id: '{{ encrypt($tarif->id) }}' })">
                                                <i class="fas fa-trash-alt text-danger mr-2"></i>
                                                Hapus
                                            </a>
                                        </li>
                                    </x-dash.table-action>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data tarif listrik yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </x-dash.table>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted text-[15px]">
                            Menampilkan {{ $tarifs->count() }} dari {{ $tarifs->total() }} data
                        </div>
                        {{ $tarifs->links('components.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('modal.tarif-modal')
</div>
