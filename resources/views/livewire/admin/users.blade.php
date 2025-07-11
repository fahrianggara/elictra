<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <div>
                        <x-spinner target="search, perPage, filterRole" />
                        Data Pengguna
                    </div>

                    <button wire:click="$dispatch('user:create')" class="btn btn-primary btn-sm">
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

                            <x-select wire:model.change="filterRole" placeholder="Peran"
                                class="w-[150px]" margin="mb-0" :options="$roles" />
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Cari pengguna..."
                                wire:model.live.debounce.500ms="search">
                        </div>
                    </div>
                    <x-dash.table headers="No, Nama, Email, Peran, Dibuat Pada, ">
                        @forelse ($users as $user)
                            <tr wire:key="user-{{ $user->id }}">
                                <td>{{ $users->firstItem() + $loop->index }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name ?? 'Tidak Ada Peran' }}</td>
                                <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data pengguna ditemukan.</td>
                            </tr>
                        @endforelse
                    </x-dash.table>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted text-[15px]">
                            Menampilkan {{ $users->count() }} dari {{ $users->total() }} data
                        </div>
                        {{ $users->links('components.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
