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
                        <form class="card-body" wire:submit.prevent="updatePassword" x-data="{ show: { old: false, new: false, confirm: false } }">
                            <p class="font-bold">Keamanan</p>

                            {{-- Kata Sandi Lama --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi Lama</label>
                                <div class="input-group">
                                    <input :type="show.old ? 'text' : 'password'"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        wire:model.defer="password" placeholder="Masukkan kata sandi yang saat ini">
                                    <button class="btn btn-outline-primary" type="button"
                                        @click="show.old = !show.old" tabindex="-1">
                                        <i :class="show.old ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Kata Sandi Baru --}}
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Kata Sandi Baru</label>
                                <div class="input-group">
                                    <input :type="show.new ? 'text' : 'password'"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                        id="new_password" wire:model.defer="new_password"
                                        placeholder="Masukkan kata sandi baru">
                                    <button class="btn btn-outline-primary" type="button"
                                        @click="show.new = !show.new" tabindex="-1">
                                        <i :class="show.new ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Konfirmasi Kata Sandi Baru --}}
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                                <div class="input-group">
                                    <input :type="show.confirm ? 'text' : 'password'"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" wire:model.defer="password_confirmation"
                                        placeholder="Konfirmasi kata sandi baru">
                                    <button class="btn btn-outline-primary" type="button"
                                        @click="show.confirm = !show.confirm" tabindex="-1">
                                        <i :class="show.confirm ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>Perbarui Kata Sandi</span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-1" role="status"
                                        aria-hidden="true"></span>
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
