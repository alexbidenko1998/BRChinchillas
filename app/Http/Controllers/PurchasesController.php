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

    function add(Request $request) {
        $purchase = $request->all();
        $purchase['id'] = DB::table('purchases')->insertGetId($purchase);
        return $purchase;
    }

    function update($id, Request $request) {
        $purchase = $request->all();
        DB::table('purchases')->where('id', $id)->update($purchase);
        return $purchase;
    }

    function delete($id) {
        DB::table('purchases')->where('id', $id)->delete();
        return ['success' => true];
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
