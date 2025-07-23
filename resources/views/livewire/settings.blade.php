<div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    Pengguna Informasi
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class=" text-[15px] font-medium text-gray-500 mb-1">Nama</label>
                        <p class="font-bold">{{ $user->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label for="name" class=" text-[15px] font-medium text-gray-500 mb-1">Email</label>
                        <p class="font-bold">{{ $user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label for="name" class=" text-[15px] font-medium text-gray-500 mb-1">Bergabung Pada</label>
                        <p class="font-bold">{{ $user->created_at->translatedFormat('l, d M Y') }}</p>
                    </div>
                    <div class="mb-0">
                        <label for="name" class=" text-[15px] font-medium text-gray-500 mb-1">Peran</label>
                        <p class="font-bold mb-1">{{ ucfirst($user->role->name) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <div class="list-group list-group-transparent">
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center active">
                                    Akun Saya
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                    Keamanan
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-9 d-flex flex-column">
                        <form class="card-body" wire:submit.prevent="updateProfile">
                            <p class="font-bold">Akun Saya</p>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" wire:model="name" required
                                    placeholder="Masukkan nama Anda">
                                @error('name') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" wire:model="email" required
                                    placeholder="Masukkan email Anda">
                                @error('email') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Perbarui Profil</span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                    Memperbarui...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
