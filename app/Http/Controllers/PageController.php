<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    function getChinchillaPage($type, $chinchillaId) {
        $chinchilla = DB::table('chinchillas')->where('id', $chinchillaId)->first();
        return response()->view('index', [
            'title' => ($type == 'purchase' ? 'Купить ' : 'Шиншилла ') . $chinchilla->name_ru,
            'description' => ($type == 'purchase' ? 'Купить ' : 'Шиншилла ') . $chinchilla->description_ru,
            'image' => ($type == 'babies' ? $chinchilla->babyAvatar :
                (isset($chinchilla->adultAvatar) ? $chinchilla->adultAvatar : $chinchilla->babyAvatar)
            )
        ]);
    }

    function getSitemap() {
        return response()->view('sitemap', [
            'adults' => (array) DB::table('chinchillas')->whereIn('status', [2, 3])->pluck('id'),
            'babies' => (array) DB::table('chinchillas')->whereIn('status', [1, 3])->pluck('id'),
            'purchases' => (array) DB::table('purchases')->where('status', '<>', 4)->pluck('chinchillaId')
        ])->header('Content-Type', 'text/xml');
    }
}
