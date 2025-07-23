<div>
    <div class="max-w-md flex min-h-screen justify-center items-center mx-auto">
        <div class="w-full">
            <img src="{{ asset('favicon/logo-text.png') }}" alt="Logo" class="mx-auto mb-6" width="160">

            <div class="bg-white rounded-xl p-6 mb-4 border border-gray-300">
                <p class="text-center text-gray-700 mb-6">
                    Silakan masuk ke akun Anda untuk melanjutkan.
                </p>
                <form wire:submit.prevent="login">
                    <div class="mb-4">
                        <input type="email" id="email" wire:model="email"
                            class="border rounded-lg w-full py-3 px-4 leading-tight focus:outline-none focus:shadow-outline border-gray-300 ring-0 focus:border-blue-500 placeholder-gray-400 @error('email') border-red-500 @enderror"
                             autofocus placeholder="Masukkan alamat email anda">

                        @error('email')
                            <p class="text-red-600 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <input type="password" id="password" wire:model="password"
                            class="border rounded-lg w-full py-3 px-4 leading-tight focus:outline-none focus:shadow-outline border-gray-300 ring-0 focus:border-blue-500 placeholder-gray-400 @error('password') border-red-500 @enderror"
                             placeholder="Masukkan kata sandi anda">

                        @error('password')
                            <p class="text-red-600 text-sm mt-2">
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
                <a href="#" class="text-blue-500 hover:text-blue-600">Daftar sekarang</a>
            </p>
        </div>
    </div>
</div>
