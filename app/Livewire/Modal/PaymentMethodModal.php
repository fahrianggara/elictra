<?php

namespace App\Livewire\Modal;

use App\Models\PaymentMethod;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class PaymentMethodModal extends Component
{
    use WithFileUploads;

    public $deleting = false;
    public $editing = false;
    public $payment_method_id;
    public $type = '';
    public $label;
    public $number;
    public $logo;
    public $oldLogo; // To store the old logo temporarily
    public $is_active = true;
    public $name;
    public $fee;

    /**
     * Mount the component with initial data if editing.
     *
     * @return void
     */
    public function updatedLogo()
    {
        // remove old image previously uploaded
        $this->deleteOldLogo(); // Delete the old logo file if it exists
        $this->oldLogo = $this->logo; // Store the new logo temporarily
    }

    /**
     * Update the label based on the type of payment method.
     *
     * @return void
     */
    public function updatedType()
    {
        $this->label = $this->type == 'bank_transfer' ? 'No.Rekening' : 'No.Akun';
    }

    /**
     * Render the payment method modal view.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.modal.payment-method-modal');
    }

    /**
     * Create a new payment method or update an existing one.
     *
     * @return void
     */
    #[On('payment-method:create')]
    public function create()
    {
        $this->onreset(); // Reset all fields and error bags
        $this->dispatch('modal:show');
    }

    /**
     * Store the payment method data.
     *
     * @return void
     */
    public function store()
    {
        $this->validate();

        $logo = uploadFile($this->logo, 'payment-methods');

        PaymentMethod::create([
            'name' => $this->name,
            'fee' => $this->fee,
            'type' => $this->type,
            'label' => $this->label,
            'number' => $this->number,
            'logo' => $logo,
            'is_active' => $this->is_active,
        ]);

        $this->deleteOldLogo(); // Delete the old logo file if it exists

        $this->close();
        $this->dispatch('payment-method:success');
        $this->dispatch('toast', icon: 'success', message: 'Data metode pembayaran berhasil disimpan.');
    }

    /**
     * Edit an existing payment method.
     *
     * @param  mixed $id
     * @return void
     */
    #[On('payment-method:edit')]
    public function edit($id)
    {
        $id = decrypt($id);
        $paymentMethod = PaymentMethod::findOrFail($id);

        $this->payment_method_id = $paymentMethod->id;
        $this->name = $paymentMethod->name;
        $this->fee = $paymentMethod->fee;
        $this->type = $paymentMethod->type;
        $this->label = $paymentMethod->label;
        $this->number = $paymentMethod->number;
        $this->logo = $paymentMethod->logo; // Load the existing logo
        $this->editing = true;

        $this->reset('deleting'); // Reset deleting state to false
        $this->dispatch('modal:show');
    }

    /**
     * Update the payment method data.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $paymentMethod = PaymentMethod::findOrFail($this->payment_method_id);

        // If a new logo is uploaded, handle the old logo deletion
        if ($this->logo instanceof TemporaryUploadedFile) {
            deleteFile($paymentMethod->logo);
            $logo = uploadFile($this->logo, 'payment-methods');
        } else {
            $logo = $paymentMethod->logo; // Keep the old logo if no new one is uploaded
        }

        $paymentMethod->update([
            'name' => $this->name,
            'fee' => $this->fee,
            'type' => $this->type,
            'label' => $this->label,
            'number' => $this->number,
            'logo' => $logo,
            'is_active' => $this->is_active,
        ]);

        $this->deleteOldLogo(); // Delete the old logo file if it exists

        $this->close();
        $this->dispatch('payment-method:success');
        $this->dispatch('toast', icon: 'success', message: 'Data metode pembayaran berhasil diperbarui.');
    }

    /**
     * Delete a payment method.
     *
     * @param  mixed $id
     * @return void
     */
    #[On('payment-method:delete')]
    public function delete($id)
    {
        $id = decrypt($id);
        $paymentMethod = PaymentMethod::findOrFail($id);

        $this->deleting = true;
        $this->payment_method_id = $paymentMethod->id;

        if ($paymentMethod->is_active) {
            $this->dispatch('toast', icon: 'error', message: 'Metode pembayaran ini tidak dapat dihapus karena masih aktif.');
            return;
        }

        $this->reset('editing'); // Reset editing state to false
        $this->dispatch('modal:show');
    }

    /**
     * Confirm the deletion of a payment method.
     *
     * @return void
     */
    public function deleted()
    {
        $paymentMethod = PaymentMethod::findOrFail($this->payment_method_id);

        // Check if the payment method is in use
        if ($paymentMethod->is_active) {
            $this->dispatch('toast', icon: 'error', message: 'Metode pembayaran ini tidak dapat dihapus karena masih aktif.');
            return;
        }

        // Delete the payment method
        deleteFile($paymentMethod->logo); // Delete the existing logo file
        $paymentMethod->delete();

        $this->close();
        $this->dispatch('payment-method:success');
        $this->dispatch('toast', icon: 'success', message: 'Data metode pembayaran berhasil dihapus.');
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
            'payment_method_id',
            'type',
            'label',
            'number',
            'logo',
            'oldLogo',
            'is_active',
            'name',
            'fee',
        ]);

        if ($this->logo instanceof TemporaryUploadedFile) {
            deleteFile("livewire-tmp/{$this->logo->getFilename()}");
        } else if ($this->oldLogo instanceof TemporaryUploadedFile) {
            deleteFile("livewire-tmp/{$this->oldLogo->getFilename()}");
        }

        $this->resetErrorBag();
    }

    /**
     * Rules for validating the payment method data.
     *
     * @return array
     */
    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'fee' => 'required|numeric|min:0|max:999999.99',
            'type' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'number' => [
                'required',
                'numeric',
                'digits_between:10,20',
                Rule::unique('payment_methods', 'number')->ignore($this->payment_method_id),
            ],
            'is_active' => 'boolean',
        ];

        if ($this->logo instanceof TemporaryUploadedFile) {
            $rules['logo'] = 'nullable|mimes:png|max:5120';
        } elseif (!$this->editing) {
            $rules['logo'] = 'required|mimes:png|max:5120';
        }

        return $rules;
    }


    /**
     * Messages for validation errors.
     *
     * @return array
     */
    protected function messages()
    {
        return [
            'logo.required'   => 'File Logo wajib diunggah.',
            'logo.max'        => 'File logo tidak boleh lebih dari 5120 kilobyte.',
            'logo.mimes'      => 'File logo harus berformat PNG.',
            'name.required'  => 'Nama metode pembayaran wajib diisi.',
            'name.string'    => 'Nama harus berupa teks.',
            'name.max'       => 'Nama tidak boleh lebih dari :max karakter.',
            'fee.required'   => 'Biaya admin wajib diisi.',
            'fee.numeric'    => 'Biaya admin harus berupa angka.',
            'fee.min'        => 'Biaya transaksi tidak boleh kurang dari :min.',
            'fee.max'        => 'Biaya transaksi tidak boleh lebih dari :max.',
            'type.required'   => 'Tipe wajib diisi.',
            'type.string'     => 'Tipe harus berupa teks.',
            'type.max'        => 'Tipe tidak boleh lebih dari :max karakter.',
            'label.required'  => 'Label wajib diisi.',
            'label.string'    => 'Label harus berupa teks.',
            'label.max'       => 'Label tidak boleh lebih dari :max karakter.',
            'number.required' => 'Nomor akun/rekening wajib diisi.',
            'number.numeric'  => 'Nomor akun/rekening harus berupa angka.',
            'number.unique'   => 'Nomor akun/rekening sudah terdaftar.',
            'number.digits_between' => 'Nomor akun/rekening harus terdiri dari antara :min dan :max digit.',
            'is_active.boolean' => 'Status aktif harus bernilai true atau false.',
        ];
    }

    /**
     * Delete the old logo file if it exists.
     *
     * @return void
     */
    private function deleteOldLogo()
    {
        if ($this->oldLogo && $this->oldLogo instanceof TemporaryUploadedFile) {
            deleteFile("livewire-tmp/{$this->oldLogo->getFilename()}");
        }
    }
}
