<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class Payments extends Component
{
    /**
     * Render the component.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.customer.payments', [

        ])->layout('dash')->title('Pembayaran');
    }
}
