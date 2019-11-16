<?php

namespace App\Http\Controllers;

use App\Chinchilla;
use Illuminate\Http\Request;

class ChinchillasController extends Controller
{
    function get() {
        $chinchillas = Chinchilla::all();
        for($i = 0; $i < count($chinchillas); $i++) {
            $chinchillas[$i]->adultPhotos = json_decode($chinchillas[$i]->adultPhotos);
            $chinchillas[$i]->babyPhotos = json_decode($chinchillas[$i]->babyPhotos);
        }
        return $chinchillas;
    }

    function addAll(Request $request) {
        foreach ($request->all() as $chinchilla) {
            $chinchilla['adultPhotos'] = json_encode($chinchilla['adultPhotos']);
            $chinchilla['babyPhotos'] = json_encode($chinchilla['babyPhotos']);
            Chinchilla::create($chinchilla);
        }
        return Chinchilla::all();
    }
}
