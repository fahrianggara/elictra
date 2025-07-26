<?php

namespace App\Livewire\Modal;

use App\Models\Customer;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerModal extends Component
{
    public $deleting = false;
    public $editing = false;
    public $customer_id;
    public $user_id;
    public $name;
    public $email;
    public $tarif_id = "";
    public $address;
    public $meter_number;
    public $initial_meter = 0;
    public $tarifs;
    public $password;
    public $password_confirmation;

    /**
     * Mount the component with the given tarifs.
     *
     * @param  mixed $tarifs
     * @return void
     */
    public function mount($tarifs)
    {
        $this->tarifs = $tarifs;
    }

    /**
     * Render the customer modal view.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.modal.customer-modal');
    }

    /**
     * Create a new customer.
     *
     * @return void
     */
    #[On('customer:create')]
    public function create()
    {
        $this->onreset(); // Reset all fields and error bags
        $this->dispatch('modal:show');
    }

    /**
     * Store the customer data.
     *
     * @return void
     */
    public function store()
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

        $this->close();
        $this->dispatch('customer:success');
        $this->dispatch('toast', icon: 'success', message: 'Data pelanggan berhasil disimpan.');
    }

    /**
     * Edit an existing customer.
     *
     * @param  mixed $id
     * @return void
     */
    #[On('customer:edit')]
    public function edit($id)
    {
        $id = decrypt($id);
        // $user = User::with('customer')->findOrFail($id);
        $customer = Customer::with('user')->findOrFail($id);

        $this->editing = true;
        $this->customer_id = $customer->id;
        $this->user_id = $customer->user->id;
        $this->name = $customer->user->name;
        $this->email = $customer->user->email;
        $this->tarif_id = $customer->tarif_id;
        $this->address = $customer->address;
        $this->meter_number = $customer->meter_number;
        $this->initial_meter = $customer->initial_meter;

        $this->reset('deleting'); // Reset deleting state to false
        $this->dispatch('modal:show');
    }

    /**
     * Update the customer data.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $customer = Customer::with('user')->findOrFail($this->customer_id);

        $customer->user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $customer->update([
            'tarif_id' => $this->tarif_id,
            'address' => $this->address,
            'meter_number' => $this->meter_number,
            'initial_meter' => $this->initial_meter,
        ]);

        $this->close();
        $this->dispatch('customer:success'); // <-- send event to Customer component
        $this->dispatch('toast', icon: 'success', message: 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Delete a customer.
     *
     * @param  mixed $id
     * @return void
     */
    #[On('customer:delete')]
    public function delete($id)
    {
        $id = decrypt($id);
        $customer = Customer::with('user')->findOrFail($id);

        $this->deleting = true;
        $this->customer_id = $customer->id;
        $this->name = $customer->user->name;

        $this->reset('editing'); // Reset editing state to false
        $this->dispatch('modal:show');
    }

    /**
     * Confirm the deletion of a customer.
     *
     * @return void
     */
    public function deleted()
    {
        $customer = Customer::with('user')->findOrFail($this->customer_id);
        $customer->user->delete(); // Delete the user associated with the customer
        $customer->delete(); // Delete the customer record

        $this->close();
        $this->dispatch('customer:success'); // <-- send event to Customer component
        $this->dispatch('toast', icon: 'success', message: 'Data pelanggan berhasil dihapus.');
    }

    /**
     * Close the customer modal.
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
            'customer_id',
            'user_id',
            'name',
            'email',
            'address',
            'tarif_id',
            'meter_number',
            'initial_meter',
            'password',
            'password_confirmation',
        ]);

        $this->resetErrorBag();
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
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            'tarif_id' => 'required|exists:tarifs,id',
            'address' => 'required|string|max:255',
            'meter_number' => [
                'required',
                'numeric',
                'digits_between:11,12',
                Rule::unique('customers', 'meter_number')->ignore($this->customer_id),
            ],
            'initial_meter' => 'required|numeric|min:0',
            'password' => 'string|min:8|max:16|' . ($this->editing ? 'nullable' : 'required'),
            'password_confirmation' => 'string|same:password|' . ($this->editing ? 'nullable' : 'required'),
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
            'password.max' => 'Kata sandi maksimal :max karakter.',

            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi kata sandi tidak cocok dengan kata sandi.',
            'password_confirmation.string' => 'Konfirmasi kata sandi harus berupa teks.',
        ];
    }
}
