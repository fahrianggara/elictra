<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Account extends Component
{
    public $user;
    public $name;
    public $email;

    /**
     * rules
     *
     * @var array
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
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
            'name.required' => 'Nama tidak boleh kosong.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'name.min' => 'Nama harus minimal 3 karakter.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
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

        // Redirect jika role pelanggan
        if ($this->user->role->name == 'pelanggan') {
            return redirect()->route('settings.security');
        }

        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.settings.account')
            ->layout('dash')
            ->title('Pengaturan Akun');
    }

    /**
     * Update the user profile.
     *
     * @return void
     */
    public function updateProfile()
    {
        $this->validate();

        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->save();

        $this->dispatch('toast', icon: 'success', message: 'Profil berhasil diperbarui.');
    }
}
