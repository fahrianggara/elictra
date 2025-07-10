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

    /**
     * Mount the component with initial data if editing.
     *
     * @return void
     */
    public function updatedLogo()
    {
        // remove old image previously uploaded
        if ($this->oldLogo && $this->oldLogo instanceof TemporaryUploadedFile) {
            deleteFile("livewire-tmp/{$this->oldLogo->getFilename()}");
        }

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
            'type' => $this->type,
            'label' => $this->label,
            'number' => $this->number,
            'logo' => $logo,
            'is_active' => $this->is_active,
        ]);

        $this->close();
        $this->dispatch('payment-method:success');
        $this->dispatch('toast', icon: 'success', message: 'Data metode pembayaran berhasil disimpan.');
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
            'is_active',
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
        return [
            'type' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'number' => [
                'required',
                'numeric',
                'digits_between:10,20',
                Rule::unique('payment_methods', 'number')->ignore($this->payment_method_id),
            ],
            'logo' => 'required|max:5120|mimes:png',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Messages for validation errors.
     *
     * @return array
     */
    protected function messages()
    {
        return [
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
            'logo.required'   => 'File Logo wajib diunggah.',
            'logo.max'        => 'File logo tidak boleh lebih dari 5120 kilobyte.',
            'logo.mimes'      => 'File logo harus berformat PNG.',
            'is_active.boolean' => 'Status aktif harus bernilai true atau false.',
        ];
    }
}
