<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use Livewire\Attributes\On;
use Livewire\Component;

class Payments extends Component
{
    public $perPage = 10;
    public $search;

    public $note;
    public $payment_id;
    public $status;

    protected $rules = [
        'note' => 'required|string|max:500|min:5',
    ];

    protected $messages = [
        'note.required' => 'Catatan diperlukan.',
        'note.string' => 'Catatan harus berupa teks.',
        'note.max' => 'Catatan tidak boleh lebih dari :max karakter.',
        'note.min' => 'Catatan harus minimal :min karakter.',
    ];
    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        $payments = Payment::with(['bill', 'method'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.payments', [
            'payments' => $payments,
            'count_pending' => Payment::query()->where('status', 'pending')->count(),
            'count_verified' => Payment::query()->where('status', 'verified')->count(),
            'count_rejected' => Payment::query()->where('status', 'rejected')->count(),
        ])->layout('dash')->title('Pembayaran');
    }

    /**
     * Function to handle note for a payment.
     *
     * @param  mixed $id
     * @param  mixed $status
     * @return void
     */
    public function modalShow($id, $status)
    {
        $payment = Payment::findOrFail(decrypt($id));
        $this->payment_id = $payment->id;
        $this->status = $status;
        $this->note = $payment->note ?? '';

        $this->dispatch('modal:show');
    }

    /**
     * note function to handle payment note.
     *
     * @return void
     */
    public function submit()
    {
        $this->validate();

        $payment = Payment::findOrFail($this->payment_id);

        $payment->update([
            'note' => $this->note,
            'status' => $this->status,
            'approved_by' => auth()->user()->id,
            'is_reupload' => $this->status == 'rejected' ? true : false,
        ]);

        $payment->bill->update([
            'status' => $this->status == 'verified' ? 'paid' : $payment->bill->status,
        ]);

        $this->close();
        $this->dispatch('toast', icon: 'success', message: 'Catatan pembayaran dan status berhasil diperbarui.');
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
            'note',
            'payment_id',
            'status',
        ]);

        $this->resetErrorBag();
    }
}
