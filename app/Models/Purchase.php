<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories;
use Illuminate\Database\Eloquent\Model;
use App\Helper\HasManyRelation;

class Purchase extends Model
{
    use HasManyRelation;


    protected $fillable=[
        'vendor_id','date','due_date','discount',
        'terms_and_conditions','reference'
    ];


      public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    
}