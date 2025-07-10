<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'type', // e.g., bank_transfer, e-wallet, etc.
        'label', // e.g., No.Rekening, No.Akun, etc.
        'number', // e.g., 1231231231321
        'logo', // URL to the logo image
        'is_active', // true or false
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
}
