<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Morder extends Model
{

    use HasFactory;

    protected $fillable = [
        'mproduct_id',
        'byname',
        'adress',
        'telefon',
        'email',
        'info',
        'nomer',
        'order_data',
        'tsum',
        'bysum',
        'status',
        'redy_data',

    ];

    public function mproduct()
    {
        return $this->belongsTo('App\Models\Mproduct');
    }



}
