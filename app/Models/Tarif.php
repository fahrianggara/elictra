<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $fillable = [
        'type', // Jenis tarif (R1, R2, R3, etc.)
        'power', // Daya dalam VA (Volt-Ampere)
        'per_kwh', // Harga per kWh
        'penalty_per_day', // Denda per hari keterlambatan
        'description', // Deskripsi tarif
    ];

    /**
     * Relasi ke model Customer.
     *
     * @return HasMany
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
