<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Security extends Component
{
    public $user;
    public $password;
    public $new_password;
    public $password_confirmation;

    /**
     * rules
     *
     * @return void
     */
    protected function rules()
    {
        return [
            'password' => 'required',
            'new_password' => 'required|min:8|max:16|different:password',
            'password_confirmation' => 'required|same:new_password',
        ];
    }

    /**
     * messages
     *
     * @return void
     */
    protected function messages()
    {
        return [
            'password.required' => 'Kata sandi lama harus diisi.',
            'new_password.required' => 'Kata sandi baru harus diisi.',
            'new_password.min' => 'Kata sandi baru minimal :min karakter.',
            'new_password.max' => 'Kata sandi baru maksimal :max karakter.',
            'new_password.different' => 'Kata sandi baru tidak boleh sama dengan kata sandi saat ini.',
            'password_confirmation.required' => 'Konfirmasi kata sandi baru harus diisi.',
            'password_confirmation.same' => 'Konfirmasi kata sandi baru harus sama dengan kata sandi baru.',
        ];
    }

    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->user = Auth::user();
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.settings.security')
            ->layout('dash')->title('Pengaturan Keamanan');
    }

    /**
     * Update the user's password.
     *
     * @return void
     */
    public function updatePassword()
    {
        $this->validate();

        if (!Hash::check($this->password, $this->user->password)) {
            $this->addError('password', 'Kata sandi lama tidak cocok.');
            return;
        }

        $this->user->update([
            'password' => $this->new_password,
        ]);

        $this->dispatch('toast', icon: 'success', message: 'Kata sandi berhasil diperbarui.');
        $this->reset(['password', 'new_password', 'password_confirmation']);
    }
}
