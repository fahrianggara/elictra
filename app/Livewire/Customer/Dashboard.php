<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class Dashboard extends Component
{
    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        $user = auth()->user();
        $customer = $user->customer;

        return view('livewire.customer.dashboard', [
            'count_bills' => $customer->bills()->count(),
            'count_bills_unpaid' => $customer->bills()->where('status', 'unpaid')->count(),
            'count_bills_paid' => $customer->bills()->where('status', 'paid')->count(),
            'user' => $user,
            'has_unpaid_bill' => $customer->bills()->where('status', 'unpaid')->exists(),
            'has_rejected_bill' => $customer->bills()
                ->whereHas('payments', fn($q) => $q->where('status', 'rejected'))
                ->exists(),
        ])->layout('dash')->title('Dashboard');
    }
}
