<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $fillable = [
        'type', // Jenis tarif (R1, R2, R3, etc.)
        'power', // Daya dalam VA (Volt-Ampere)
        'price_per_kwh', // Harga per kWh
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

    /**
     * Scope untuk mencari tarif berdasarkan kriteria tertentu.
     *
     * @param  mixed $query
     * @param  mixed $search
     * @return void
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('description', 'like', "%{$search}%")
                ->orWhereRaw("CONCAT(type, ' - ', power, 'VA') LIKE ?", ["%{$search}%"])
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('power', 'like', "%{$search}%");
        });
    }

    /**
     * getFormatTarifAttribute
     *
     * @return void
     */
    public function getFormatTarifAttribute()
    {
        return "{$this->type} / {$this->power} VA";
    }
}
