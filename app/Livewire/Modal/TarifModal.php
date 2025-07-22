<?php

namespace App\Livewire\Modal;

use App\Models\Tarif;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class TarifModal extends Component
{
    public $deleting = false;
    public $editing = false;
    public $tarif_id;
    public $type;
    public $power;
    public $price_per_kwh;
    public $penalty_per_day;
    public $description;

    /**
     * Render the view for the Tarif Modal component.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.modal.tarif-modal');
    }

    /**
     * Create a new tarif.
     *
     * @return void
     */
    #[On('tarif:create')]
    public function create()
    {
        $this->onreset(); // Reset all fields and error bags
        $this->dispatch('modal:show');
    }

    /**
     * Store the tarif data.
     *
     * @return void
     */
    public function store()
    {
        $this->validate();

        Tarif::create([
            'type' => $this->type,
            'power' => $this->power,
            'price_per_kwh' => $this->price_per_kwh,
            'penalty_per_day' => $this->penalty_per_day,
            'description' => $this->description,
        ]);

        $this->close();
        $this->dispatch('tarif:success');
        $this->dispatch('toast', icon: 'success', message: 'Data tarif berhasil disimpan.');
    }

    /**
     * Edit an existing tarif.
     *
     * @param  mixed $id
     * @return void
     */
    #[On('tarif:edit')]
    public function edit($id)
    {
        $id = decrypt($id);
        $tarif = Tarif::findOrFail($id);

        $this->tarif_id = $tarif->id;
        $this->type = $tarif->type;
        $this->power = $tarif->power;
        $this->price_per_kwh = $tarif->price_per_kwh;
        $this->penalty_per_day = $tarif->penalty_per_day;
        $this->description = $tarif->description;
        $this->editing = true;

        $this->reset('deleting'); // Reset deleting state to false
        $this->dispatch('modal:show');
    }

    /**
     * Update the tarif data.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $tarif = Tarif::findOrFail($this->tarif_id);
        $tarif->update([
            'type' => $this->type,
            'power' => $this->power,
            'price_per_kwh' => $this->price_per_kwh,
            'penalty_per_day' => $this->penalty_per_day,
            'description' => $this->description,
        ]);

        $this->close();
        $this->dispatch('tarif:success');
        $this->dispatch('toast', icon: 'success', message: 'Data tarif berhasil diperbarui.');
    }

    /**
     * Delete a tarif.
     *
     * @param  mixed $id
     * @return void
     */
    #[On('tarif:delete')]
    public function delete($id)
    {
        $id = decrypt($id);
        $tarif = Tarif::withCount('customers')->findOrFail($id);

        $this->deleting = true;
        $this->tarif_id = $tarif->id;
        $this->type = $tarif->type;
        $this->power = $tarif->power;

        if ($this->isTarifInUse($tarif)) return;

        $this->reset('editing'); // Reset editing state to false
        $this->dispatch('modal:show');
    }

    /**
     * Confirm the deletion of a tarif.
     *
     * @return void
     */
    public function deleted()
    {
        $tarif = Tarif::withCount('customers')->findOrFail($this->tarif_id);

        if ($this->isTarifInUse($tarif)) return;

        $tarif->delete();

        $this->close();
        $this->dispatch('tarif:success');
        $this->dispatch('toast', icon: 'success', message: 'Data tarif berhasil dihapus.');
    }

    /**
     * Close the tarif modal.
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
            'tarif_id',
            'type',
            'power',
            'price_per_kwh',
            'penalty_per_day',
            'description',
        ]);

        $this->resetErrorBag();
    }

    /**
     * Rules for the tarif modal form validation.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'type' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tarifs')->where(function ($query) {
                    return $query->where('type', $this->type)->where('power', $this->power);
                })->ignore($this->tarif_id),
            ],
            'power' => 'required|numeric|min:0',
            'price_per_kwh' => 'required|numeric|min:0',
            'penalty_per_day' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
        ];
    }

    /**
     * Custom validation messages
     *
     * @return array
     */
    protected function messages()
    {
        return [
            'type.required' => 'Tipe tarif wajib diisi.',
            'type.string'   => 'Tipe tarif harus berupa teks.',
            'type.max'      => 'Tipe tarif maksimal :max karakter.',
            'type.unique'   => "Tipe {$this->type} dengan daya {$this->power} ini sudah ada. Silakan pilih tipe tarif yang berbeda.",
            'power.required' => 'Daya wajib diisi.',
            'power.numeric' => 'Daya harus berupa angka.',
            'power.min'     => 'Daya tidak boleh kurang dari :min.',
            'price_per_kwh.required' => 'Harga per KWh wajib diisi.',
            'price_per_kwh.numeric'  => 'Harga per KWh harus berupa angka.',
            'price_per_kwh.min'      => 'Harga per KWh tidak boleh kurang dari :min.',
            'penalty_per_day.numeric' => 'Denda per hari harus berupa angka.',
            'penalty_per_day.required' => 'Denda per hari wajib diisi.',
            'penalty_per_day.min'    => 'Denda per hari tidak boleh kurang dari :min.',
            'description.required'    => 'Deskripsi wajib diisi.',
            'description.string'     => 'Deskripsi harus berupa teks.',
            'description.max'        => 'Deskripsi maksimal :max karakter.',
        ];
    }

    /**
     * Check if tarif is used by any customer and show error toast if true.
     *
     * @param  Tarif  $tarif
     * @return bool
     */
    protected function isTarifInUse(Tarif $tarif): bool
    {
        if ($tarif->customers_count > 0) {
            $message = "Tarif ini tidak dapat dihapus! karena sudah digunakan oleh {$tarif->customers_count} pelanggan.";

            $this->dispatch(
                'toast',
                fireOptions: ['icon' => 'error', 'title' => $message],
                mixinOptions: ['position' => 'top-end', 'timer' => 5000],
            );

            return true;
        }

        return false;
    }
}
