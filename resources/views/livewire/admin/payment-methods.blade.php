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
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Cari metode pembayaran..."
                                wire:model.live.debounce.500ms="search">
                        </div>
                    </div>
                    <x-dash.table headers="No, Tipe Pembayaran, Label, Nomor Pembayaran, Logo, Status, ">
                        <tr>
                            <td>1</td>
                            <td>bank_transfer</td>
                            <td>No. Rekening</td>
                            <td>123123012399213</td>
                            <td>
                                <img src="https://www.bca.co.id/-/media/Feature/Card/List-Card/Tentang-BCA/Brand-Assets/Logo-BCA/Logo-BCA_Biru.png"
                                    alt="Bank Transfer" class="h-[50px]">
                            </td>
                            <td>
                                <span class="badge bg-success">Aktif</span>
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
                    </x-dash.table>
                </div>
            </div>
        </div>
    </div>
</div>
