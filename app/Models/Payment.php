<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'proof_file',
        'status',
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

    /**
     * getColorAttribute
     *
     * @return void
     */
    public function getColorAttribute()
    {
        $statusBadges = [
            'rejected' => 'text-danger-emphasis bg-danger-subtle border-danger-subtle',
            'verified' => 'text-success-emphasis bg-success-subtle border-success-subtle',
            'pending' => 'text-warning-emphasis bg-warning-subtle border-warning-subtle',
        ];

        return $statusBadges[$this->status] ?? 'text-secondary-emphasis bg-secondary-subtle border-secondary-subtle';
    }

    /**
     * getStatusFormatAttribute
     *
     * @return void
     */
    public function getStatusFormatAttribute()
    {
        $format = [
            'rejected' => 'Ditolak',
            'verified' => 'Terverifikasi',
            'pending' => 'Menunggu Verifikasi',
        ];

        return $format[$this->status] ?? 'Tidak Diketahui';
    }
}
