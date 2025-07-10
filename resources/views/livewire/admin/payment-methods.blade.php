<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <x-spinner target="edit, destroy, search, perPage" />
                        Data Metode Pembayaran
                    </div>

                    <button wire:click="$dispatch('payment-method:create')" class="btn btn-primary btn-sm">
                        Tambah
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

                            <x-select wire:model.change="filterType" placeholder="Tipe Pembayaran"
                                class="w-[190px]" margin="mb-0" :options="[
                                    'all' => 'Semua',
                                    'bank_transfer' => 'Transfer Bank',
                                    'e_wallet' => 'Dompet Digital',
                                ]" />

                            <x-select wire:model.change="filterStatus" placeholder="Status"
                                class="w-[150px]" margin="mb-0" :options="[
                                    'all' => 'Semua',
                                    1 => 'Aktif',
                                    0 => 'Tidak Aktif',
                                ]" />
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Cari metode pembayaran..."
                                wire:model.live.debounce.500ms="search">
                        </div>
                    </div>
                    <x-dash.table headers="No, Tipe Pembayaran, Label, Nomor Pembayaran, Logo, Status, ">
                        @forelse ($paymentMethods as $paymentMethod)
                            <tr>
                                <td>{{ $paymentMethods->firstItem() + $loop->index }}</td>
                                <td>{{ $paymentMethod->type }}</td>
                                <td>{{ $paymentMethod->label }}</td>
                                <td>{{ $paymentMethod->number }}</td>
                                <td>
                                    <img src="https://www.bca.co.id/-/media/Feature/Card/List-Card/Tentang-BCA/Brand-Assets/Logo-BCA/Logo-BCA_Biru.png"
                                        alt="Bank Transfer" class="h-[50px]">
                                        {{-- <img src="{{ getFile($paymentMethod->logo) }}" alt="Bank Transfer" class="h-[50px]"> --}}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $paymentMethod->is_active ? 'success' : 'secondary' }}">
                                        {{ $paymentMethod->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <x-dash.table-action>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                wire:click="$dispatch('payment-method:edit', { id: 'a' })">
                                                <i class="fas fa-edit text-warning mr-2"></i>
                                                Edit
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                wire:click="$dispatch('payment-method:delete', { id: 'a' })">
                                                <i class="fas fa-trash-alt text-danger mr-2"></i>
                                                Hapus
                                            </a>
                                        </li>
                                    </x-dash.table-action>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data metode pembayaran.</td>
                            </tr>
                        @endforelse

                    </x-dash.table>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted text-[15px]">
                            Menampilkan {{ $paymentMethods->count() }} dari {{ $paymentMethods->total() }} data
                        </div>
                        {{ $paymentMethods->links('components.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
