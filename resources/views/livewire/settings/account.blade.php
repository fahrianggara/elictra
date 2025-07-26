<div>
    <div class="row g-3">
        <div class="col-lg-3">
            @include('livewire.settings.information')
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        @include('livewire.settings.menu')
                    </div>

                    <div class="col-12 col-md-9 d-flex flex-column">
                        <form class="card-body" wire:submit.prevent="updateProfile">
                            <p class="font-bold">Akun Saya</p>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model="name"
                                    required placeholder="Masukkan nama Anda">
                                @error('name')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            @if($user->role->name == 'pelanggan')
                                <div class="mb-3">
                                    <label for="address" class="form-label">Alamat</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" wire:model="address"
                                        required placeholder="Masukkan alamat Anda">
                                    @error('address')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            @if($user->role->name != 'pelanggan')
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                        wire:model="email" required placeholder="Masukkan email Anda">
                                    @error('email')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

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
