<?php

namespace App\Livewire\Customer;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Payments extends Component
{
    use WithFileUploads;

    public $step_total = 3;
    public $step_current = 1;
    public $step_1 = false;
    public $step_2 = false;
    public $step_3 = false;
    public $steps;

    public $payment_method_id;
    public $invoice;
    public $payment_method;
    public $total;
    public $bill;

    #[Validate]
    public $proof_file;

    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'proof_file' => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120', // 5MB max
        ];
    }

    /**
     * messages
     *
     * @return void
     */
    public function messages()
    {
        return [
            'proof_file.required' => 'Bukti pembayaran harus diunggah.',
            'proof_file.file' => 'Bukti pembayaran harus berupa file.',
            'proof_file.mimes' => 'Bukti pembayaran harus berupa file dengan format jpeg, jpg, png, atau pdf.',
            'proof_file.max' => 'Bukti pembayaran tidak boleh lebih dari 5MB.',
        ];
    }

    /**
     * updated
     *
     * @param  mixed $property
     * @return void
     */
    public function updated($property)
    {
        if ($property === 'payment_method_id') {
            $this->payment_method = PaymentMethod::findOrFail($this->payment_method_id);
            $this->total = $this->bill->amount + $this->payment_method->fee;
        }

        if ($property === 'proof_file') {
            // maximize the file size to 5MB
            if ($this->proof_file && $this->proof_file->getSize() > 5120 * 1024) {
                // $this->dispatch('toast', icon: 'error', message: 'Ukuran file bukti pembayaran tidak boleh lebih dari 5MB.');
                if ($this->proof_file && $this->proof_file instanceof TemporaryUploadedFile)
                    deleteFile("livewire-tmp/{$this->proof_file->getFilename()}");
                $this->proof_file = null; // reset the file
            }
        }
    }

    /**
     * Mount the component with the given invoice.
     *
     * @param  mixed $invoice
     * @return void
     */
    public function mount($invoice)
    {
        $this->invoice = $invoice;
        $this->bill = Bill::where('invoice', $this->invoice)
            ->where('status', 'unpaid')
            ->firstOrFail();
    }

    /**
     * Render the component.
     *
     * @return void
     */
    public function render()
    {
        $paymentMethods = PaymentMethod::where('is_active', true)
            ->orderBy('name')->get()->groupBy('type');

        return view('livewire.customer.payments', [
            'paymentMethods' => $paymentMethods,
        ])->layout('dash')->title('Pembayaran');
    }

    /**
     * Proceed to the next step.
     *
     * @return void
     */
    public function nextStep()
    {
        // validate payment_method if not selected
        if ($this->step_current === 1 && !$this->payment_method) {
            $this->dispatch('toast', icon: 'error', message: 'Silakan pilih metode pembayaran terlebih dahulu.');
            return;
        }

        if ($this->step_current < $this->step_total) {
            $this->step_current++;
            $this->updateSteps();
        }
    }

    /**
     * Proceed to the previous step.
     *
     * @return void
     */
    public function previousStep()
    {
        if ($this->step_current > 1) {
            $this->step_current--;
            $this->updateSteps();
        }
    }

    /**
     * Update the step visibility based on the current step.
     *
     * @return void
     */
    public function updateSteps()
    {
        $this->step_1 = $this->step_current === 1;
        $this->step_2 = $this->step_current === 2;
        $this->step_3 = $this->step_current === 3;

        $this->steps = [
            'step_1' => $this->step_1,
            'step_2' => $this->step_2,
            'step_3' => $this->step_3,
        ];
    }

    /**
     * Submit the payment.
     *
     * @return void
     */
    public function submit()
    {
        $this->validate();

        // Save the payment proof file
        $proof = uploadFile($this->proof_file, 'payments');

        // Create a new payment record
        $payment = Payment::create([
            'amount' => $this->total,
            'proof_file' => $proof,
            'status' => 'pending',
            'bill_id' => $this->bill->id,
            'method_id' => $this->payment_method_id,
        ]);

        $this->bill->update([
            'status' => 'waiting',
        ]);

        // remove the old proof file if it exists
        if ($this->proof_file && $this->proof_file instanceof TemporaryUploadedFile) {
            deleteFile("livewire-tmp/{$this->proof_file->getFilename()}");
        }

        $this->dispatch('toast', icon: 'success', message: 'Pembayaran berhasil diajukan. Silakan tunggu verifikasi dari admin.');
        return $this->redirect(route('customer.bills.history'), true);
    }
}
