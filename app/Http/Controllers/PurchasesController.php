<?php

namespace App\Http\Controllers;

use App\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    function get() {
        return Purchase::all();
    }

    function addAll(Request $request) {
        foreach ($request->all() as $purchase) {
            DB::table("purchases")->insert($purchase);
        }
        return Purchase::all();
    }

    function deleteAll(Request $request) {
        DB::table('purchases')->delete();
        return Purchase::all();
    }
}
