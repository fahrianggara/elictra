<?php

namespace App\Livewire\Admin;

use App\Models\PaymentMethod;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentMethods extends Component
{
    use WithPagination;

    public $perPage = 10; // Default number of items per page
    public $search;
    public $filterType = '';
    public $filterStatus = '';

    // Reset pagination when search or filter changes
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'filterType', 'filterStatus'])) {
            $this->resetPage();
        }
    }

    /**
     * Filtering the payment methods based on search and filters.
     *
     * @param  mixed $query
     * @return object
     */
    public function filtering($query)
    {
        return $query
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->when($this->filterType && $this->filterType !== 'all', function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterStatus !== '' && $this->filterStatus !== 'all', function ($query) {
                $query->where('is_active', $this->filterStatus == 1);
            })
            ->orderBy('is_active', 'desc')
            ->orderBy('id', 'desc');
    }

    /**
     * Render the payment methods view.
     *
     * @return void
     */
    #[On('payment-method:success')]
    public function render()
    {
        $paymentMethods = $this->filtering(PaymentMethod::query())->paginate($this->perPage);

        return view('livewire.admin.payment-methods', [
            'paymentMethods' => $paymentMethods
        ])->layout('dash')->title('Metode Pembayaran');
    }

    /**
     * Update the status of a payment method.
     *
     * @param  mixed $id
     * @param  mixed $value
     * @return void
     */
    public function updateStatus($id, $value)
    {
        try {
            $method = PaymentMethod::find(decrypt($id));
            if ($method) {
                $method->is_active = (bool) $value;
                $method->save(); // Gunakan save() bukan update()

                $this->dispatch(
                    'toast',
                    icon: 'success',
                    message: 'Status metode pembayaran berhasil diperbarui.',
                    mixinOptions: [
                        'timer' => 2500,
                    ]
                );
            }
        } catch (\Exception $e) {
            $this->dispatch('toast', icon: 'error', message: 'Terjadi kesalahan saat memperbarui status.');
        }
    }
}
