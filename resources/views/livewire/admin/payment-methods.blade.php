<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <x-spinner target="updated, search, perPage, updateStatus, filterType, filterStatus" />
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

                            <x-select wire:model.change="filterType" placeholder="Tipe Pembayaran" class="w-[190px]"
                                margin="mb-0" :options="[
                                    'all' => 'Semua',
                                    'bank_transfer' => 'Transfer Bank',
                                    'e_wallet' => 'Dompet Digital',
                                ]" />

                            <x-select wire:model.change="filterStatus" placeholder="Status" class="w-[150px]"
                                margin="mb-0" :options="[
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
                    <x-dash.table headers="No, Logo, Nama, Tipe Pembayaran, Label, Nomor Pembayaran, Status, Total Digunakan, Biaya Admin, ">
                        @forelse ($paymentMethods as $paymentMethod)
                            <tr wire:key="payment-method-{{ $paymentMethod->id }}">
                                <td>{{ $paymentMethods->firstItem() + $loop->index }}</td>
                                <td>
                                    <img src="{{ getFile($paymentMethod->logo) }}"
                                        class="h-[50px] w-[80px] object-contain rounded"
                                        alt="{{ $paymentMethod->label }}">
                                </td>
                                <td>{{ $paymentMethod->name }}</td>
                                <td>{{ $paymentMethod->type_format }}</td>
                                <td>{{ $paymentMethod->label }}</td>
                                <td>{{ $paymentMethod->number }}</td>
                                <td>
                                    <select wire:change="updateStatus('{{ encrypt($paymentMethod->id) }}', $event.target.value)"
                                        wire:loading.attr="disabled" wire:target="updateStatus"
                                        class="form-select" wire:key="select-{{ $paymentMethod->id }}"
                                        style="width: 140px;">
                                        <option value="1" {{ $paymentMethod->is_active ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="0" {{ !$paymentMethod->is_active ? 'selected' : '' }}>Tidak
                                            Aktif</option>
                                    </select>
                                </td>
                                <td>{{ $paymentMethod->payments_count == 0 ? '-' : $paymentMethod->payments_count }}</td>
                                <td>{{ rupiah($paymentMethod->fee) }}</td>
                                <td>
                                    <x-dash.table-action>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                wire:click="$dispatch('payment-method:edit', { id: '{{ encrypt($paymentMethod->id) }}' })">
                                                <i class="fas fa-edit text-warning mr-2"></i>
                                                Edit
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                                wire:click="$dispatch('payment-method:delete', { id: '{{ encrypt($paymentMethod->id) }}' })">
                                                <i class="fas fa-trash-alt text-danger mr-2"></i>
                                                Hapus
                                            </a>
                                        </li>
                                    </x-dash.table-action>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data metode pembayaran.</td>
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

    @livewire('modal.payment-method-modal')
</div>
