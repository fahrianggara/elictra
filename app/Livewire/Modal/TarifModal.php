<?php

namespace App\Livewire\Modal;

use App\Models\Tarif;
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
        $this->dispatch(
            'tarif:success', // <-- send event to Customer component
            type: 'success',
            message: 'Data tarif berhasil disimpan.'
        );
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
            'type' => 'required|string|max:255',
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
            'power.required'=> 'Daya wajib diisi.',
            'power.numeric' => 'Daya harus berupa angka.',
            'power.min'     => 'Daya tidak boleh kurang dari :min.',
            'price_per_kwh.required' => 'Harga per KWh wajib diisi.',
            'price_per_kwh.numeric'  => 'Harga per KWh harus berupa angka.',
            'price_per_kwh.min'      => 'Harga per KWh tidak boleh kurang dari :min.',
            'penalty_per_day.numeric'=> 'Denda per hari harus berupa angka.',
            'penalty_per_day.required' => 'Denda per hari wajib diisi.',
            'penalty_per_day.min'    => 'Denda per hari tidak boleh kurang dari :min.',
            'description.required'    => 'Deskripsi wajib diisi.',
            'description.string'     => 'Deskripsi harus berupa teks.',
            'description.max'        => 'Deskripsi maksimal :max karakter.',
        ];
    }
}
