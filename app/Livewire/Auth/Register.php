<?php

namespace App\Livewire\Auth;

use App\Models\Tarif;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $email;
    public $tarif_id = "";
    public $address;
    public $meter_number;
    public $initial_meter;
    public $password;
    public $password_confirmation;

    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        $tarifs = Tarif::all();

        return view('livewire.auth.register', [
            'tarifs' => $tarifs,
        ])->layout('auth')->title('Register');
    }

    /**
     * Register a new customer.
     *
     * @return void
     */
    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password), // Default password, can be changed later
            'role_id' => 3, // 3 = Customer role
        ]);

        $user->customer()->create([
            'tarif_id' => $this->tarif_id,
            'address' => $this->address,
            'meter_number' => $this->meter_number,
            'initial_meter' => $this->initial_meter,
        ]);

        session()->flash('success', 'Pendaftaran berhasil, silakan masuk.');
        return $this->redirect(route('login'), true);
    }

    /**
     * Rules for validating customer data.
     *
     * @return void
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|min:3',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'tarif_id' => 'required|exists:tarifs,id',
            'address' => 'required|string|max:255',
            'meter_number' => [
                'required',
                'numeric',
                'digits_between:11,12',
                Rule::unique('customers', 'meter_number'),
            ],
            'initial_meter' => 'required|numeric|min:0',
            'password' => 'string|min:8|required',
            'password_confirmation' => 'string|same:password|required',
        ];
    }

    /**
     * Messages for validation errors.
     *
     * @return void
     */
    protected function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal :max karakter.',
            'name.min' => 'Nama minimal :min karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal :max karakter.',
            'email.unique' => 'Email sudah terdaftar.',

            'tarif_id.required' => 'Tarif wajib dipilih.',
            'tarif_id.exists' => 'Tarif yang dipilih tidak tersedia.',

            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat maksimal :max karakter.',

            'meter_number.required' => 'Nomor meter wajib diisi.',
            'meter_number.numeric' => 'Nomor meter harus berupa angka.',
            'meter_number.digits_between' => 'Nomor meter harus terdiri dari :min sampai :max digit.',
            'meter_number.unique' => 'Nomor meter sudah terdaftar.',

            'initial_meter.required' => 'Meter awal wajib diisi.',
            'initial_meter.numeric' => 'Meter awal harus berupa angka.',
            'initial_meter.min' => 'Meter awal minimal bernilai :min.',

            'password.required' => 'Kata sandi wajib diisi.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi minimal :min karakter.',

            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi kata sandi harus sama dengan kata sandi.',
            'password_confirmation.string' => 'Konfirmasi kata sandi harus berupa teks.',
        ];
    }
}
