<?php

namespace App\Livewire\Modal;

use App\Models\Bill;
use Livewire\Attributes\On;
use Livewire\Component;

class BillModal extends Component
{
    public $deleting = false;
    public $editing = false;
    public $customer_id = '';
    public $month;
    public $year;
    public $meter_start;
    public $meter_end;
    public $status;
    public $due_date;
    public $period;
    public $customers = [];

    /**
     * Mount the component with the given customers.
     *
     * @param  mixed $customers
     * @return void
     */
    public function mount($customers)
    {
        $this->customers = $customers;
    }

    /**
     * Render the view for the bill modal.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.modal.bill-modal');
    }

    /**
     * Create a new bill.
     *
     * @return void
     */
    #[On('bill:create')]
    public function create()
    {
        $this->onreset(); // Reset all fields and error bags
        $this->dispatch('modal:show');
    }

    /**
     * Close the bill modal.
     *
     * @return void
     */
    public function close()
    {
        $this->dispatch('modal:hide');
    }

    /**
     * Close the modal and reset all fields.
     *
     * @return void
     */
    #[On('modal:onreset')]
    public function onreset()
    {
        $this->reset([
            'deleting',
            'editing',
            'customer_id',
            'month',
            'year',
            'meter_start',
            'meter_end',
            'status',
            'due_date',
            'period',
        ]);

        $this->resetErrorBag();
    }
}
