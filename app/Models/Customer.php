<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'meter_number',
        'address',
        'initial_meter',
        'is_blocked',
        'block_reason',
        'user_id',
        'tarif_id',
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

    /**
     * Scope for searching customers based on meter number, address, or user name.
     *
     * @param  mixed $query
     * @param  mixed $search
     * @return void
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('meter_number', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('tarif', function ($q) use ($search) {
                    $q->whereRaw("CONCAT(type, ' - ', power, 'VA') LIKE ?", ["%{$search}%"])
                        ->orWhere('type', 'like', "%{$search}%")
                        ->orWhere('power', 'like', "%{$search}%");
                });
        });
    }

    /**
     * Get the last bill for the customer.
     *
     * @return void
     */
    public function getLastBillAttribute()
    {
        return $this->bills
            ->where('status', '!=', 'unpaid')
            ->sortByDesc('period')
            ->first();
    }
}
