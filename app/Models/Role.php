<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Fillable attributes for the Role model.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Define the relationship between Role and User models.
     *
     * @return void
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
