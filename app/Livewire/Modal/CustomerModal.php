<?php

namespace App\Livewire\Modal;

use App\Models\Tarif;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerModal extends Component
{
    /**
     * Render the customer modal view.
     *
     * @return void
     */
    public function render()
    {
        $tarifs = Tarif::all()->mapWithKeys(function ($item) {
            return [$item->id => "{$item->type} - {$item->power}VA"];
        })->toArray();

        return view('livewire.modal.customer-modal', [
            'tarifs' => $tarifs
        ]);
    }

    /**
     * Create a new customer.
     *
     * @return void
     */
    #[On('customer:create')]
    public function create()
    {
        $this->dispatch('modal:show');
    }

    /**
     * Close the customer modal.
     *
     * @return void
     */
    public function close()
    {
        $this->dispatch('modal:hide');
    }
}
