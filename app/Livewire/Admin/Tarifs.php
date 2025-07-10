<?php

namespace App\Livewire\Admin;

use App\Models\Tarif;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Tarifs extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 10;

    /**
     * Render the component view.
     *
     * @return void
     */
    #[On('tarif:success')]
    public function render()
    {
        $tarifs = Tarif::query()
            ->withCount('customers')
            ->when($this->search, fn($query) => $query->search($this->search))
            ->orderBy('customers_count', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.tarifs', [
            'tarifs' => $tarifs,
        ])->layout('dash')->title('Tarif Listrik');
    }
}
