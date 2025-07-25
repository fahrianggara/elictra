<?php

namespace App\Livewire\Customer;

use App\Models\Bill;
use App\Models\Payment;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BillHistories extends Component
{
    use WithPagination, WithFileUploads;

    public $perPage = 10;
    public $filterStatus = 'all';
    public $search;

    public $payment_id;

    #[Validate]
    public $proof_file;

    protected $rules = [
        'proof_file' => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120', // 5MB max
    ];

    protected $messages = [
        'proof_file.required' => 'Bukti pembayaran harus diunggah.',
        'proof_file.file' => 'Bukti pembayaran harus berupa file.',
        'proof_file.mimes' => 'Bukti pembayaran harus berupa file dengan format jpeg, jpg, png, atau pdf.',
        'proof_file.max' => 'Bukti pembayaran tidak boleh lebih dari 5MB.',
    ];

    /**
     * updated
     *
     * @param  mixed $property
     * @return void
     */
    public function updated($property)
    {
        if ($property === 'proof_file') {
            if ($this->proof_file && $this->proof_file->getSize() > 5120 * 1024) {
                if ($this->proof_file && $this->proof_file instanceof TemporaryUploadedFile)
                    deleteFile("livewire-tmp/{$this->proof_file->getFilename()}");

                $this->proof_file = null; // reset the file
            }
        }
    }

    /**
     * Render the component.
     *
     * @return void
     */
    public function render()
    {
        $payments = Payment::query()
            ->with(['bill.customer', 'bill.customer.tarif', 'bill.customer.user'])
            ->when($this->search, function ($query) {
                $query->whereHas('bill.customer', function ($q) {
                    $q->where('invoice', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus  !== 'all', fn ($query) => $query->where('status', $this->filterStatus))
            ->whereHas('bill', function ($query) {
                $query->where('customer_id', auth()->user()->customer->id);
            })->paginate($this->perPage);

        return view('livewire.customer.bill-histories', [
            'payments' => $payments,
        ])->layout('dash')->title('Riwayat Tagihan');
    }

    /**
     * Show the modal for payment details.
     *
     * @param  mixed $id
     * @return void
     */
    public function modalShow($id)
    {
        $this->payment_id = decrypt($id);
        $this->dispatch('modal:show');
    }

    /**
     * Submit the payment proof.
     *
     * @return void
     */
    public function submit()
    {
        $this->validate();

        // Handle the file upload and payment proof submission logic here
        $payment = Payment::findOrFail($this->payment_id);

        if ($this->proof_file instanceof TemporaryUploadedFile) {
            deleteFile($payment->proof_file);
            $proof = uploadFile($this->proof_file, 'payments');
            deleteFile("livewire-tmp/{$this->proof_file->getFilename()}");
        }

        $payment->update([
            'proof_file' => $proof ?? $payment->proof_file,
            'status' => 'pending',
            'is_reupload' => false,
        ]);

        $this->close();
        $this->dispatch('toast', icon: 'success', message: 'Bukti pembayaran berhasil diunggah. Silakan tunggu konfirmasi.');
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
            'proof_file',
            'payment_id'
        ]);

        $this->resetErrorBag();
    }
}
