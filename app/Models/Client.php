<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'inn',
        'adres',
        'telefon',

    ];

    public function order()
    {
        return $this->hasMany('App\Models\Order');
    }

}
