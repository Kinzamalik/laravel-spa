<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'firstname', 'lastname', 'email', 'address',
    ];

    protected $appends = ['text'];

    public function getTextAttribute()
    {
        return $this->attributes['firstname'] . ' - ' . $this->attributes['lastname'];
    }


      public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
