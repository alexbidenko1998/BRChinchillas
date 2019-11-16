<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chinchilla extends Model
{
    protected $fillable = [
        'id', 'name_ru', 'name_en', 'description_ru', 'description_en', 'birthday', 'adultAvatar', 'babyAvatar',
        'adultPhotos', 'babyPhotos', 'mother', 'father', 'status'
    ];

    protected $casts = [
        'adultPhotos' => 'array',
        'babyPhotos' => 'array'
    ];

    protected $table = 'chinchillas';
}
