<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'nomer',
        'order_data',
        'tsum',
        'status'
    ];

   public function bodyorder()
    {
        return $this->hasMany('App\Models\BodyOrder');
    }

    public function payment()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

}
