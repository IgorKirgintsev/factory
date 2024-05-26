<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class BodyOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'category_id',
        'kol',
        'price',
        'bsum',

    ];

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

//   public function product()
//    {
//        return $this->belongsTo(Product::class);
//    }

     public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
     public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

}
