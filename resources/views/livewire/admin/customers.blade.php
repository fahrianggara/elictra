<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    Data Pelanggan

                    <button class="btn btn-primary btn-sm">
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
                                wire:model.debounce.500ms="search">
                        </div>
                    </div>

                    <x-dash.table headers="ID, Nama, Email, Telepon, Aksi">
                        <tr>
                            <td>AWDAWDWD</td>
                            <td>Nama Pelanggan</td>
                            <td>Email Pelanggan</td>
                            <td>08123456789</td>
                            <td>Action</td>
                        </tr>
                    </x-dash.table>
                </div>
            </div>
        </div>
    </div>
</div>
