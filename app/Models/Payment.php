<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_date',
        'amount',
        'proof_file',
        'verified',
        'bill_id',
        'method_id',
        'note',
        'is_reupload',
        'approved_by',
    ];

    /**
     * A payment belongs to a bill.
     *
     * @return BelongsTo
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    /**
     * A payment belongs to a payment method.
     *
     * @return BelongsTo
     */
    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'method_id');
    }
}
