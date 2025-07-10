<?php

namespace App\Livewire\Admin;

use App\Models\PaymentMethod;
use Livewire\Attributes\On;
use Livewire\Component;

class PaymentMethods extends Component
{
    public $perPage = 10; // Default number of items per page
    /**
     * Render the payment methods view.
     *
     * @return void
     */
    #[On('payment-method:success')]
    public function render()
    {
        $paymentMethods = PaymentMethod::query()
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.payment-methods', [
            'paymentMethods' => $paymentMethods
        ])->layout('dash')->title('Metode Pembayaran');
    }
}
