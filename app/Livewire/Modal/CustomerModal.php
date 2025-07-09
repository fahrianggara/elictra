<?php

namespace App\Livewire\Modal;

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
        return view('livewire.modal.customer-modal');
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
