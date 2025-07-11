<?php

namespace App\Livewire\Modal;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class UserModal extends Component
{
    public $deleting = false;
    public $editing = false;
    public $user_id;
    public $name;
    public $email;
    public $role_id = '';
    public $password;
    public $password_confirmation;
    public $roles = [];

    /**
     * Mount the component.
     *
     * @param  mixed $roles
     * @return void
     */
    public function mount($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.modal.user-modal');
    }

    /**
     * Create a new user.
     *
     * @return void
     */
    #[On('user:create')]
    public function create()
    {
        $this->onreset(); // Reset all fields and error bags
        $this->dispatch('modal:show');
    }

    /**
     * Store a new user.
     *
     * @return void
     */
    public function store()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => trim($this->email),
            'role_id' => $this->role_id,
            'password' => bcrypt($this->password),
        ]);

        $this->close();
        $this->dispatch('user:success');
        $this->dispatch('toast', icon: 'success', message: 'Data pengguna berhasil disimpan.');
    }

    /**
     * Edit an existing user.
     *
     * @return void
     */
    #[On('user:edit')]
    public function edit($id)
    {
        $id = decrypt($id);
        $user = User::findOrFail($id);

        $this->editing = true;
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;

        $this->reset('deleting');
        $this->dispatch('modal:show');
    }

    /**
     * Update the user data.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $user = User::findOrFail($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => trim($this->email),
            'role_id' => $this->role_id,
        ]);

        $this->close();
        $this->dispatch('user:success');
        $this->dispatch('toast', icon: 'success', message: 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Close the modal.
     *
     * @return void
     */
    public function close()
    {
        $this->dispatch('modal:hide');
    }

    /**
     * Close the modal and reset all fields.
     *
     * @return void
     */
    #[On('modal:onreset')]
    public function onreset()
    {
        $this->reset([
            'deleting',
            'editing',
            'user_id',
            'name',
            'email',
            'role_id',
            'password',
            'password_confirmation',
        ]);

        $this->resetErrorBag();
    }

    /**
     * Rules untuk validasi input pengguna.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email:rfc,dns',
                'regex:/^\s*[^\s@]+@[^\s@]+\.[^\s@]+\s*$/',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            'role_id' => 'required|exists:roles,id',
            'password' => 'string|min:8|max:16|' . ($this->editing ? 'nullable' : 'required'),
            'password_confirmation' => 'string|min:8|max:16|same:password|' . ($this->editing ? 'nullable' : 'required'),
        ];
    }

    /**
     * Pesan error kustom dalam bahasa Indonesia untuk validasi.
     *
     * @return array
     */
    protected function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari :max karakter.',
            'email.unique' => 'Email sudah digunakan.',
            'email.regex' => 'Format email tidak valid.',
            'role_id.required' => 'Peran harus dipilih.',
            'role_id.exists' => 'Peran yang dipilih tidak valid.',
            'password.required' => 'Kata sandi harus diisi.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi minimal :min karakter.',
            'password.max' => 'Kata sandi maksimal :max karakter.',
            'password_confirmation.required' => 'Konfirmasi kata sandi harus diisi.',
            'password_confirmation.string' => 'Konfirmasi kata sandi harus berupa teks.',
            'password_confirmation.min' => 'Konfirmasi kata sandi minimal :min karakter.',
            'password_confirmation.max' => 'Konfirmasi kata sandi maksimal :max karakter.',
            'password_confirmation.same' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi.',
        ];
    }
}
