<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Account extends Component
{
    public $user;
    public $name;
    public $email;
    public $address;

    /**
     * rules
     *
     * @var array
     */
    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
        ];

        if ($this->user->customer) {
            $rules['address'] = 'required|string|max:500';
        }

        return $rules;
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
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'name.min' => 'Nama harus minimal :min karakter.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari :max karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'address.required' => 'Alamat tidak boleh kosong.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat tidak boleh lebih dari :max karakter.',
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

        $this->name = $this->user->name;
        $this->email = $this->user->email;

        if ($this->user->customer)
            $this->address = $this->user->customer->address;
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

        if ($this->user->customer) {
            $this->user->customer->address = $this->address;
            $this->user->customer->save();
        }

        $this->dispatch('toast', icon: 'success', message: 'Profil berhasil diperbarui.');
    }
}
