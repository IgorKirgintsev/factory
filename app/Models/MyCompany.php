<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'inn',
        'adress',
        'director',
        'email',
        'bank',
        'image',
    ];





}
