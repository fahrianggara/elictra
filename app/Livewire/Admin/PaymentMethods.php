<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class PaymentMethods extends Component
{
    /**
     * Render the payment methods view.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.admin.payment-methods', [

        ])->layout('dash')->title('Metode Pembayaran');
    }
}
