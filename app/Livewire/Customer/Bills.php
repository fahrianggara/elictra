<?php

namespace App\Livewire\Customer;

use App\Models\Bill;
use Livewire\Component;
use Livewire\WithPagination;

class Bills extends Component
{
    use WithPagination;

    public $perPage = 10;

    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        $bills = Bill::query()
            ->with(['customer', 'customer.tarif'])
            ->where('customer_id', auth()->user()->customer->id)
            ->where('status', 'unpaid')
            ->orderBy('period', 'desc')->orderBy('status', 'asc')
            ->paginate($this->perPage);

        return view('livewire.customer.bills', [
            'bills' => $bills
        ])->layout('dash')->title('Tagihan');
    }
}
