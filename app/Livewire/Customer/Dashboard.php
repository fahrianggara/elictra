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
        return view('livewire.customer.dashboard', [

        ])->layout('dash')->title('Dashboard');
    }
}
