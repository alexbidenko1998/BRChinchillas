<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'id', 'chinchillaId', 'description_ru', 'description_en', 'rubles', 'euros', 'status'
    ];

    protected $table = 'purchases';
}
