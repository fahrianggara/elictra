<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    /**
     * Rules for the login form validation.
     *
     * @return void
     */
    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'remember' => 'boolean',
        ];
    }

    /**
     * Messages for the validation rules.
     *
     * @return void
     */
    protected function messages()
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal harus 6 karakter.',
            'remember.boolean' => 'Pilihan ingat saya harus berupa boolean.',
        ];
    }

    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.auth.login')->layout('auth')->title('Login');
    }

    /**
     * Login method to handle user authentication.
     *
     * @return void
     */
    public function login()
    {
        $this->validate();

        // Attempt login
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $user = Auth::user();

            if ($user->role->name == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role->name == 'petugas') {
                return redirect()->route('officer.dashboard');
            } else {
                return redirect()->route('customer.dashboard');
            }
        }

        $this->addError('email', 'Oops! Akun tidak ditemukan atau kata sandi salah.');
    }
}
