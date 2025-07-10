<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Tarifs extends Component
{
    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.admin.tarifs', [

        ])->layout('dash')->title('Tarif Listrik');
    }
}
