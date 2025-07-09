<?php

namespace App\Livewire\Modal;

use App\Models\Tarif;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerModal extends Component
{
    public $deleting = false;
    public $editing = false;
    public $user_id;
    public $name;
    public $email;
    public $tarif_id = "";
    public $address;
    public $meter_number;
    public $initial_meter;

    /**
     * Render the customer modal view.
     *
     * @return void
     */
    public function render()
    {
        $tarifs = Tarif::all()->mapWithKeys(function ($item) {
            return [$item->id => "{$item->type} - {$item->power}VA"];
        })->toArray();

        return view('livewire.modal.customer-modal', [
            'tarifs' => $tarifs
        ]);
    }

    /**
     * Create a new customer.
     *
     * @return void
     */
    #[On('customer:create')]
    public function create()
    {
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
            'password' => bcrypt($this->meter_number), // Default password, can be changed later
            'role_id' => 3, // 3 = Customer role
        ]);

        $user->customer()->create([
            'tarif_id' => $this->tarif_id,
            'address' => $this->address,
            'meter_number' => $this->meter_number,
            'initial_meter' => $this->initial_meter,
        ]);

        $this->close();
        $this->dispatch(
            'customer:success', // <-- send event to Customer component
            type: 'success',
            message: 'Data pelanggan berhasil dibuat.'
        );
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
        $user = User::with('customer')->findOrFail($id);

        $this->editing = true;
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->tarif_id = $user->customer->tarif_id;
        $this->address = $user->customer->address;
        $this->meter_number = $user->customer->meter_number;
        $this->initial_meter = $user->customer->initial_meter;

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

        $user = User::findOrFail($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $user->customer()->update([
            'tarif_id' => $this->tarif_id,
            'address' => $this->address,
            'meter_number' => $this->meter_number,
            'initial_meter' => $this->initial_meter,
        ]);

        $this->close();
        $this->dispatch(
            'customer:success', // <-- send event to Customer component
            type: 'success',
            message: 'Data pelanggan berhasil diperbarui.'
        );
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
        $user = User::findOrFail($id);

        $this->deleting = true;
        $this->user_id = $user->id;
        $this->name = $user->name;

        $this->dispatch('modal:show');
    }

    /**
     * Confirm the deletion of a customer.
     *
     * @return void
     */
    public function deleted()
    {
        User::findOrFail($this->user_id)->delete();

        $this->close();
        $this->dispatch(
            'customer:success', // <-- send event to Customer component
            type: 'success',
            message: 'Data pelanggan berhasil dihapus.'
        );
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
            'user_id',
            'name',
            'email',
            'address',
            'tarif_id',
            'meter_number',
            'initial_meter',
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
            'email' => 'required|email|max:255|unique:users,email,' . $this->user_id,
            'tarif_id' => 'required|exists:tarifs,id',
            'address' => 'required|string|max:255',
            'meter_number' => 'required|numeric|digits_between:11,12|unique:customers,meter_number,' . $this->user_id,
            'initial_meter' => 'required|numeric|min:0',
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
        ];
    }
}
