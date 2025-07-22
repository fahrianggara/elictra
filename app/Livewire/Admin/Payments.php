<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use Livewire\Component;

class Payments extends Component
{
    public $perPage = 10;
    public $search;
    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        $payments = Payment::with(['bill', 'method'])
            ->orderBy('payment_date', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.payments', [
            'payments' => $payments
        ])->layout('dash')->title('Pembayaran');
    }
}
