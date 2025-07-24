<?php

namespace App\Livewire\Customer;

use App\Models\PaymentMethod;
use Livewire\Component;

class Payments extends Component
{
    public $step_total = 3;
    public $step_current = 1;
    public $step_1 = false;
    public $step_2 = false;
    public $step_3 = false;
    public $steps;

    public $proof_file;
    public $payment_method;

    /**
     * Render the component.
     *
     * @return void
     */
    public function render()
    {
        $paymentMethods = PaymentMethod::where('is_active', true)
            ->orderBy('name')->get()->groupBy('type');

        return view('livewire.customer.payments', [
            'paymentMethods' => $paymentMethods,
        ])->layout('dash')->title('Pembayaran');
    }

    /**
     * Proceed to the next step.
     *
     * @return void
     */
    public function nextStep()
    {
        // validate payment_method if not selected
        if ($this->step_current === 1 && !$this->payment_method) {
            $this->dispatch('toast', icon: 'error', message: 'Silakan pilih metode pembayaran terlebih dahulu.');
            return;
        }

        if ($this->step_current < $this->step_total) {
            $this->step_current++;
            $this->updateSteps();
        }
    }

    /**
     * Proceed to the previous step.
     *
     * @return void
     */
    public function previousStep()
    {
        if ($this->step_current > 1) {
            $this->step_current--;
            $this->updateSteps();
        }
    }

    /**
     * Update the step visibility based on the current step.
     *
     * @return void
     */
    public function updateSteps()
    {
        $this->step_1 = $this->step_current === 1;
        $this->step_2 = $this->step_current === 2;
        $this->step_3 = $this->step_current === 3;

        $this->steps = [
            'step_1' => $this->step_1,
            'step_2' => $this->step_2,
            'step_3' => $this->step_3,
        ];
    }
}
