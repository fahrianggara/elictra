<?php

namespace App\Livewire\Customer;

use App\Models\Bill;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class BillHistories extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $filterStatus = 'all';
    public $search;

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
}
