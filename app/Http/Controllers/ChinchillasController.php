<?php

namespace App\Http\Controllers;

use App\Chinchilla;
use Illuminate\Http\Request;

class ChinchillasController extends Controller
{
    function get() {
        return Chinchilla::all();
    }

    function addAll(Request $request) {
        foreach ($request->all() as $chinchilla) {
            Chinchilla::create($chinchilla);
        }
        return Chinchilla::all();
    }
}
