<div>
    <div class="max-w-md flex min-h-screen justify-center items-center mx-auto my-6 mb-8">
        <div class="w-full">
            <img src="{{ asset('favicon/logo-text.png') }}" alt="Logo" class="mx-auto mb-6" width="160">

            <div class="bg-white rounded-xl p-6 mb-4 border border-gray-300">
                <p class="text-center text-gray-700 mb-6">
                    Silakan daftar untuk membuat akun baru dan mulai menggunakan layanan kami.
                </p>

                <form wire:submit.prevent="register">
                    {{-- Pastikan Font Awesome sudah terpasang di layout utama --}}
                    <div class="form-auth">
                        <span class="auth-input-icon @error('name') bottom-[28px] @enderror">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" wire:model="name" placeholder="Nama Lengkap"
                            class="auth-input-field @error('name') border-red-500 focus:ring-red-500 @enderror">
                        @error('name')
                            <p class="auth-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-auth">
                        <span
                            class="auth-input-icon @error('email') bottom-[28px] @enderror">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" wire:model="email" placeholder="Alamat Email"
                            class="auth-input-field @error('email') border-red-500 focus:ring-red-500 @enderror">
                        @error('email')
                            <p class="auth-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-auth">
                        <span
                            class="auth-input-icon  @error('tarif_id') bottom-[28px] @enderror">
                            <i class="fas fa-bolt"></i>
                        </span>
                        <select wire:model="tarif_id"
                            class="auth-select-field @error('tarif_id') border-red-500 focus:ring-red-500 @enderror">
                            <option value="" selected hidden>Pilih Tarif</option>
                            @foreach ($tarifs as $tarif)
                                <option value="{{ $tarif->id }}">{{ $tarif->format_tarif }}</option>
                            @endforeach
                        </select>
                        <div
                            class="pointer-events-none absolute right-4 text-gray-500
                            {{ $errors->has('tarif_id') ? 'bottom-[38px]' : 'top-1/2 transform -translate-y-1/2' }}">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        @error('tarif_id')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-auth">
                        <span
                            class="auth-input-icon @error('address') bottom-[28px] @enderror">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <input type="text" wire:model="address" placeholder="Alamat"
                            class="auth-input-field @error('address') border-red-500 focus:ring-red-500 @enderror">
                        @error('address')
                            <p class="auth-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-auth">
                        <span
                            class="auth-input-icon @error('meter_number') bottom-[28px] @enderror">
                            <i class="fas fa-tachometer-alt"></i>
                        </span>
                        <input type="number" wire:model="meter_number" placeholder="Nomor Meteran/kWh"
                            class="auth-input-field @error('meter_number') border-red-500 focus:ring-red-500 @enderror">
                        @error('meter_number')
                            <p class="auth-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-auth">
                        <span
                            class="auth-input-icon @error('initial_meter') bottom-[28px] @enderror">
                            <i class="fas fa-sort-numeric-up-alt"></i>
                        </span>
                        <input type="number" wire:model="initial_meter" placeholder="Meter Awal" min="0"
                            class="auth-input-field @error('initial_meter') border-red-500 focus:ring-red-500 @enderror">

                        @error('initial_meter')
                            <p class="auth-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-auth">
                        <span
                            class="auth-input-icon @error('password') bottom-[28px] @enderror">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" wire:model="password" placeholder="Kata Sandi"
                            class="auth-input-field @error('password') border-red-500 focus:ring-red-500 @enderror">
                        @error('password')
                            <p class="auth-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6 relative">
                        <span
                            class="auth-input-icon @error('password_confirmation') bottom-[28px] @enderror">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" wire:model="password_confirmation" placeholder="Konfirmasi Kata Sandi"
                            class="auth-input-field @error('password_confirmation') border-red-500 focus:ring-red-500 @enderror">
                        @error('password_confirmation')
                            <p class="auth-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full bg-blue-500 text-white font-medium py-3 px-4 rounded-lg hover:bg-blue-600 focus:outline-none
                        focus:shadow-outline cursor-pointer transition duration-200 mb-2 disabled:pointer-events-none disabled:opacity-50">
                        <span wire:loading.remove>Daftar</span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-1" role="status"
                                aria-hidden="true"></span>
                            Memproses...
                        </span>
                    </button>
                </form>
            </div>

            <p class="text-center text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600">Login</a>
            </p>
        </div>
    </div>
</div>
