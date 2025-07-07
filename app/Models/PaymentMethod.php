<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'label',
        'icon',
        'is_active',
        'number',
        'description'
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
