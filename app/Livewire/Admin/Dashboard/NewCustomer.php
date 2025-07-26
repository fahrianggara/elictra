<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Customer;
use Carbon\Carbon;
use Livewire\Component;

class NewCustomer extends Component
{
    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        $now = Carbon::now();

        $customers = Customer::with('user')
            ->whereBetween('created_at', [
                $now->copy()->startOfWeek(), // default Senin
                $now->copy()->endOfWeek(),   // default Minggu
            ])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard.new-customer', [
            'customers' => $customers
        ]);
    }
}
