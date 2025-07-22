<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name', // e.g., Bank BCA, OVO, etc.
        'fee', // e.g., 5000.00 (transaction fee)
        'type', // e.g., bank_transfer, e-wallet, etc.
        'label', // e.g., No.Rekening, No.Akun, etc.
        'number', // e.g., 1231231231321
        'logo', // URL to the logo image
        'is_active', // true or false
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'fee' => 'decimal:2', // Ensure fee is stored as a decimal with 2 places
    ];

    /**
     * Payment methods can have many payments associated with them.
     *
     * @return void
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'method_id');
    }

    /**
     * Scope to search payment methods by label, number, or type.
     *
     * @param  mixed $query
     * @param  mixed $search
     * @return void
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('label', 'like', '%' . $search . '%')
            ->orWhere('number', 'like', '%' . $search . '%')
            ->orWhere('type', 'like', '%' . $search . '%');
    }

    /**
     * Get the formatted type of the payment method.
     *
     * @return void
     */
    public function getTypeFormatAttribute()
    {
        return match ($this->type) {
            'bank_transfer' => 'Transfer Bank',
            'e_wallet' => 'Dompet Digital',
            'credit_card' => 'Kartu Kredit',
            default => 'Lainnya',
        };
    }
}
