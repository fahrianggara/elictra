<?php

namespace App\Livewire\Admin;

use App\Models\Bill;
use Livewire\Component;

class Bills extends Component
{
    public $filterStatus = '';
    public $search = '';
    public $perPage = 10;

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        $bills = Bill::query()
            ->with(['customer', 'customer.tarif'])
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->search, function ($query) {

            })->paginate($this->perPage);

        return view('livewire.admin.bills', [
            'bills' => $bills
        ])->layout('dash')->title('Tagihan');
    }
}
