<?php

namespace App\Livewire\Modal;

use App\Models\Role;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class RoleModal extends Component
{
    public $role_id;
    public $name;
    public $description;
    public $deleting = false;
    public $editing = false;

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.modal.role-modal');
    }

    /**
     * Create a new role.
     *
     * @return void
     */
    #[On('role:create')]
    public function create()
    {
        $this->reset(); // Reset all fields and error bags
        $this->dispatch('modal:show');
    }

    /**
     * Store the role data.
     *
     * @return void
     */
    public function store()
    {
        $this->validate();

        Role::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->close();
        $this->dispatch('role:success');
        $this->dispatch('toast', icon: 'success', message: 'Data peran baru berhasil disimpan.');
    }

    /**
     * Edit an existing role.
     *
     * @param  mixed $id
     * @return void
     */
    #[On('role:edit')]
    public function edit($id)
    {
        $id = decrypt($id);
        $role = Role::findOrFail($id);

        $this->role_id = $role->id;
        $this->name = $role->name;
        $this->description = $role->description;
        $this->editing = true;

        $this->reset('deleting'); // Reset deleting state to false
        $this->dispatch('modal:show');
    }

    /**
     * Update the role data.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $role = Role::findOrFail($this->role_id);
        $role->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->close();
        $this->dispatch('role:success');
        $this->dispatch('toast', icon: 'success', message: 'Data peran berhasil diperbarui.');
    }

    /**
     * Delete a role.
     *
     * @param  mixed $id
     * @return void
     */
    #[On('role:delete')]
    public function delete($id)
    {
        $id = decrypt($id);
        $role = Role::withCount('users')->findOrFail($id);

        $this->deleting = true;
        $this->role_id = $role->id;
        $this->name = $role->name;
        $this->description = $role->description;

        if ($this->isRoleInUse($role)) return;

        $this->reset('editing'); // Reset editing state to false
        $this->dispatch('modal:show');
    }

    /**
     * Confirm the deletion of a role.
     *
     * @return void
     */
    public function deleted()
    {
        $role = Role::withCount('users')->findOrFail($this->role_id);

        if ($this->isRoleInUse($role)) return;

        $role->delete();

        $this->close();
        $this->dispatch('role:success');
        $this->dispatch('toast', icon: 'success', message: 'Data peran berhasil dihapus.');
    }

    /**
     * Check if the role is in use by any users.
     *
     * @param  Role $role
     * @return bool
     */
    protected function isRoleInUse(Role $role)
    {
        if ($role->users_count > 0) {
            $this->dispatch('toast', icon: 'error', message: "Peran ini tidak dapat dihapus karena masih digunakan oleh {$role->users_count} pengguna.");
            return true;
        }
        return false;
    }

    /**
     * Close the role modal.
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
            'role_id',
            'name',
            'description',
            'deleting',
            'editing',
        ]);

        $this->resetErrorBag();
    }

    /**
     * Rules for validating role data.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($this->role_id)],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array
     */
    protected function messages()
    {
        return [
            'name.required' => 'Nama peran harus diisi.',
            'name.unique' => 'Peran dengan nama ini sudah ada.',
            'name.string' => 'Nama peran harus berupa teks.',
            'name.max' => 'Nama peran tidak boleh lebih dari :max karakter.',
            'description.max' => 'Deskripsi tidak boleh lebih dari :max karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
