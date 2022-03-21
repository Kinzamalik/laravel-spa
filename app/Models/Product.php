<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[
        'description', 'unit_price'
    ];

    protected $appends = ['text'];

    public function getTextattribute()
    {
        return $this->attributes['item_code'].'-'.$this->attributes['description'];
    }
}
