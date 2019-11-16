<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    function get() {
        return Purchase::all();
    }

    function addAll(Request $request) {
        foreach ($request->all() as $chinchilla) {
            Purchase::create($chinchilla);
        }
        return Purchase::all();
    }
}
