<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <div class="spinner-border spinner-border-sm me-2" wire:loading wire:target="edit, destroy"
                            role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        Data Pelanggan
                    </div>

                    <button wire:click="$dispatch('customer:create')" class="btn btn-primary btn-sm">
                        Tambah Pelanggan
                    </button>
                </div>

                <div class="card-body">
                    <div class="row mb-3 justify-content-between">
                        <div class="col-md-2">
                            <select class="form-select" wire:model="perPage">
                                <option value="10">10 per halaman</option>
                                <option value="25">25 per halaman</option>
                                <option value="50">50 per halaman</option>
                                <option value="100">100 per halaman</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Cari Pelanggan..."
                                wire:model.live.debounce.500ms="search">
                        </div>
                    </div>

                    <x-dash.table headers="No, Nama & Email, Alamat, No. Meteran, Tarif Listrik, Status, ">
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $customer->user->name }}
                                    <p class="mb-0 text-muted">{{ $customer->user->email }}</p>
                                </td>
                                <td class="w-[40%]">{{ $customer->address }}</td>
                                <td>{{ $customer->meter_number }}</td>
                                <td>{{ $customer->tarif->type }} - {{ $customer->tarif->power }}VA</td>
                                <td>
                                    <span class="badge bg-{{ $customer->is_blocked ? 'danger' : 'success' }}">
                                        {{ $customer->is_blocked ? 'Terblokir' : 'Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <x-dash.table-action>
                                        <li>
                                            <a class="dropdown-item" href="#" wire:click="$dispatch('customer:edit', { id: '{{ encrypt($customer->id) }}' })">
                                                <i class="fas fa-edit text-warning mr-2"></i>
                                                Edit
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="#" wire:click="$dispatch('customer:destroy', { id: '{{ encrypt($customer->id) }}' })">
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

                    <div class="mt-3">
                        {{ $customers->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('modal.customer-modal')
</div>
