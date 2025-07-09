<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Customers extends Component
{
    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.admin.customers')
            ->layout('dash')
            ->title('Pelanggan');
    }
}
