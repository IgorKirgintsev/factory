<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BodyOrder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'ed',
        'price',
        'info',
        'image',
    ];


   public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
//    public function bodyorder()
//    {
//        return $this->belongsTo(BodyOrder::class,'product_id');
 //   }

}
