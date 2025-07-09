<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    Data Pelanggan

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
                        <tr>
                            <td>1</td>
                            <td>
                                Fahri Anggara
                                <p class="mb-0 text-muted">fahriangga@mail.com</p>
                            </td>
                            <td>
                                Jl. Lorem Ipsum Dolor Sit Amet No. 123 Jakarta Selatan
                            </td>
                            <td>1234567890</td>
                            <td>R-1/900</td>
                            <td>
                                <span class="badge bg-success">Aktif</span>
                            </td>
                            <td>
                                <x-dash.table-action>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-edit text-warning mr-2"></i>
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-trash text-danger mr-2"></i>
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

    @livewire('modal.customer-modal')
</div>
