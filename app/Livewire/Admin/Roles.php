<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class Roles extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';

    /**
     * Render the component view.
     *
     * @return void
     */
    public function render()
    {
        $roles = Role::query()
            ->withCount('users')
            ->when($this->search, fn($query) => $query->search(trim($this->search)))
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.admin.roles', [
            'roles' => $roles
        ])->layout('dash')->title('Peran Pengguna');
    }
}
