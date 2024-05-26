<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mproduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'info',
        'image',
        'price',

    ];

    public function morder()
    {
        return $this->hasMany('App\Models\Morder');
    }



}
