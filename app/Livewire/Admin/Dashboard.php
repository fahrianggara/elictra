<?php

namespace App\Livewire\Admin;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Payment;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Dashboard extends Component
{
    /**
     * Render the admin dashboard view.
     *
     * @return void
     */
    #[On('dashboard:refresh')]
    public function render()
    {
        $now = Carbon::now();

        $monthlyIncome = Payment::where('status', 'verified')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('amount');

        return view('livewire.admin.dashboard', [
            'count_customers' => Customer::count(),
            'count_bill_unpaid' => Bill::where('status', 'unpaid')->count(),
            'count_payment_pending' => Payment::where('status', 'pending')->count(),
            'monthly_income' => $monthlyIncome,
        ])->layout('dash')->title('Admin Dashboard');
    }
}
