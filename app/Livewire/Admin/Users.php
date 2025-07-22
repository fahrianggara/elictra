<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $filterRole = '';
    public $search;

    /**
     * Filtering the users based on search and role.
     *
     * @param  mixed $query
     * @return object
     */
    public function filtering($query)
    {
        return $query->with(['role'])
            // ->where('user_id', '!=', Auth::id())
            ->when($this->search, fn ($q) => $q->search($this->search))
            ->when($this->filterRole, fn ($q) => $q->whereHas('role', fn ($q) => $q->where('id', $this->filterRole)))
            ->where('id', '!=', Auth::id())
            ->orderBy('created_at', 'desc');
    }

    /**
     * Render the component view.
     *
     * @return void
     */
    #[On('user:success')]
    public function render()
    {
        $roles = Role::all()->where('name', '!=', 'pelanggan')->mapWithKeys(function ($item) {
            return [$item->id => $item->name_format];
        })->toArray();

        $users = $this->filtering(User::query())->paginate($this->perPage);

        return view('livewire.admin.users', [
            'roles' => $roles,
            'users' => $users,
        ])->layout('dash')->title('Pengguna');
    }
}
