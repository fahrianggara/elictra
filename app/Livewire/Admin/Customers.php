<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\Tarif;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Customers extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search;
    public $filterTarif = '';
    public $filterStatus = '';

    /**
     * Filtering method to handle search and pagination.
     *
     * @return object
     */
    public function filtering($query)
    {
        return $query->when($this->search, fn ($q) => $q->search($this->search))
            ->when($this->filterTarif, fn ($q) => $q->where('tarif_id', $this->filterTarif))
            ->when($this->filterStatus !== 'all', fn ($q) => $q->where('is_blocked', $this->filterStatus))
            ->with(['tarif', 'user'])
            ->withCount(['bills'])
            ->orderBy('created_at', 'desc');
    }

    /**
     * Render the customers view with pagination.
     *
     * @return void
     */
    #[On('customer:success')]
    public function render()
    {
        $customers = $this->filtering(Customer::query())->paginate($this->perPage);

        $tarifs = Tarif::all()->mapWithKeys(function ($item) {
            return [$item->id => "{$item->type} - {$item->power}VA"];
        })->toArray();

        return view('livewire.admin.customers', [
            'customers' => $customers,
            'tarifs' => $tarifs,
        ])->layout('dash')->title('Pelanggan');
    }
}
