<div>
    <div class="max-w-md flex min-h-screen justify-center items-center mx-auto">
        <div class="w-full">
            <img src="{{ asset('favicon/logo-text.png') }}" alt="Logo" class="mx-auto mb-6" width="160">

            <div class="bg-white rounded-xl p-6 mb-4 border border-gray-300">
                <p class="text-center text-gray-700 mb-6">
                    Silakan masuk ke akun Anda untuk melanjutkan.
                </p>
                <form wire:submit.prevent="login">
                    <div class="form-auth">
                        <span class="auth-input-icon @error('email') bottom-[28px] @enderror">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" wire:model="email" placeholder="Masukkan alamat email"
                            class="auth-input-field @error('email') border-red-500 focus:ring-red-500 @enderror">
                        @error('email')
                            <p class="auth-error-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-auth">
                        <span class="auth-input-icon @error('password') bottom-[28px] @enderror">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" wire:model="password"
                            class="auth-input-field @error('password') border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Masukkan kata sandi anda">

                        @error('password')
                            <p class="auth-error-text">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-6 flex items-center justify-between">
                        <label class="inline-flex items-center text-gray-700 ">
                            <input type="checkbox" wire:model="remember"
                                class="form-checkbox h-5 w-5 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            <span class="ml-2 text-[15px] cursor-pointer">Tetap Masuk?</span>
                        </label>
                        {{-- <a href="#" class="text-blue-500 hover:text-blue-600 text-sm">Lupa password?</a> --}}
                    </div>

                    <button type="submit" wire:loading.attr="disabled"
                        class="w-full bg-blue-500 text-white font-medium py-3 px-4 rounded-lg hover:bg-blue-600 focus:outline-none
                        focus:shadow-outline cursor-pointer transition duration-200 mb-2 disabled:pointer-events-none disabled:opacity-50">
                        <span wire:loading.remove>Masuk</span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-1" role="status"
                                aria-hidden="true"></span>
                            Memproses...
                        </span>
                    </button>
                </form>
            </div>

            <p class="text-center text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-600">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>
