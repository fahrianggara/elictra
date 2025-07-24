<?php

namespace App\Livewire\Admin;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\User;
use Livewire\Attributes\On;
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
    #[On('bill:success')]
    public function render()
    {
        $bills = Bill::query()
            ->with(['customer', 'customer.tarif'])
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->when($this->search, function ($query) {

            })->paginate($this->perPage);

        $customers = Customer::with('user')->get()
        ->mapWithKeys(function ($customer) {
            return [$customer->id => $customer->user->name . ' (' . $customer->meter_number . ')'];
        })->toArray();

        return view('livewire.admin.bills', [
            'bills' => $bills,
            'customers' => $customers,
        ])->layout('dash')->title('Tagihan');
    }
}
