<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    /**
     * Render the admin dashboard view.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('dash')
            ->title('Admin Dashboard');
    }
}
