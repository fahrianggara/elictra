<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $fillable = [
        'power', // Daya dalam VA (Volt-Ampere)
        'per_kwh', // Harga per kWh
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
