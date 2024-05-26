<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'client_id',
        'nomer',
        'pay_data',
        'psum',
        'status',
        'typ_doc',
        'metod',

    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }






}
