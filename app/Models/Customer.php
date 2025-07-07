<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'meter_number',
        'address',
        'initial_meter',
        'is_blocked',
        'block_reason',
        'user_id',
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
    ];

    /**
     * Relasi ke model User.
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Tarif.
     *
     * @return void
     */
    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }

    /**
     * Relasi ke model Tagihan.
     *
     * @return void
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
