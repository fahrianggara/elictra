<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
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
        return $this->usage * $this->customer->tarif->per_kwh;
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
}
