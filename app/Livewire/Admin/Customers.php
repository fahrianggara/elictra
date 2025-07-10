<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\Tarif;
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

        $tarifs = Tarif::all()->mapWithKeys(function ($item) {
            return [$item->id => "{$item->type} - {$item->power}VA"];
        })->toArray();

        return view('livewire.admin.customers', [
            'customers' => $customers,
            'tarifs' => $tarifs,
        ])->layout('dash')->title('Pelanggan');
    }
}
