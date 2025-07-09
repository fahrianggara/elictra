<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

class Customers extends Component
{
    /**
     * Render the customers view with pagination.
     *
     * @return void
     */
    #[On('customer:success')]
    public function render()
    {
        $customers = Customer::query()
            ->with(['tarif', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.customers', [
            'customers' => $customers,
        ])->layout('dash')->title('Pelanggan');
    }
}
