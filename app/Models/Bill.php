<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'invoice',
        'customer_id',
        'period',
        'meter_start',
        'meter_end',
        'status',
        'due_date',
    ];

    /**
     * Customer relationship.
     *
     * @return void
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Accessor for penalty attribute.
     *
     * @return void
     */
    public function getPenaltyAttribute()
    {
        // tidak hitung ulang jika sudah dibayar / diblokir maka tidak ada denda
        if ($this->status !== 'unpaid' && $this->status !== 'overdue') {
            return 0;
        }

        // Cek apakah tanggal jatuh tempo sudah terlewat
        $daysLate = Carbon::now()->diffInDays($this->due_date, false);

        // Jika tanggal jatuh tempo belum terlewat, tidak ada denda.
        return $daysLate > 0 ? $daysLate * $this->customer->tarif->penalty_per_day : 0;
    }

    /**
     * Accessor for usage attribute.
     *
     * @return void
     */
    public function getUsageAttribute()
    {
        return $this->meter_end - $this->meter_start;
    }

    /**
     * Accessor for total amount attribute.
     *
     * @return void
     */
    public function getAmountAttribute()
    {
        return $this->usage * $this->customer->tarif->price_per_kwh;
    }

    /**
     * Accessor for total amount with penalty.
     *
     * @return void
     */
    public function getTotalAttribute()
    {
        return $this->amount + $this->penalty;
    }

    /**
     * Scope to filter unpaid bills.
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    /**
     * Scope to filter paid bills.
     *
     * @param  mixed $query
     * @return void
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope to filter overdue bills.
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    /**
     * Scope to filter blocked bills.
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeBlocked($query)
    {
        return $query->where('status', 'blocked');
    }

    /**
     * getColorAttribute
     *
     * @return void
     */
    public function getColorAttribute()
    {
        $statusBadges = [
            'unpaid' => 'text-danger-emphasis bg-danger-subtle border-danger-subtle',
            'paid' => 'text-success-emphasis bg-success-subtle border-success-subtle',
            'waiting' => 'text-warning-emphasis bg-warning-subtle border-warning-subtle',
            'blocked' => 'text-secondary-emphasis bg-secondary-subtle border-secondary-subtle',
            'overdue' => 'text-danger-emphasis bg-danger-subtle border-danger-subtle',
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
            'unpaid' => 'Belum Dibayar',
            'paid' => 'Lunas',
            'waiting' => 'Menunggu Verifikasi',
            'blocked' => 'Diblokir',
            'overdue' => 'Terlambat',
        ];

        return $format[$this->status] ?? 'Tidak Diketahui';
    }

    public function scopeSearch($query, $search)
    {
        $query->where(function ($query) use ($search) {
            $query->whereHas('customer', function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })->orWhere('meter_number', 'like', '%' . $search . '%');
            });
        });
    }
}
