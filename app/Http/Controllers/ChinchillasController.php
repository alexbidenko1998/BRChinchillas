<?php

namespace App\Http\Controllers;

use App\Chinchilla;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    function add(Request $request) {
        $chinchilla = $request->all();
        $chinchilla['adultPhotos'] = json_encode($chinchilla['adultPhotos']);
        $chinchilla['babyPhotos'] = json_encode($chinchilla['babyPhotos']);
        $chinchilla['id'] = DB::table("chinchillas")->insertGetId($chinchilla);
        $chinchilla['adultPhotos'] = json_decode($chinchilla['adultPhotos']);
        $chinchilla['babyPhotos'] = json_decode($chinchilla['babyPhotos']);
        return $chinchilla;
    }

    function update($id, Request $request) {
        $chinchilla = $request->all();
        $oldChinchilla = DB::table('chinchillas')->where('id', $id)->first();
        $oldChinchilla->adultPhotos = json_decode($oldChinchilla->adultPhotos);
        $oldChinchilla->babyPhotos = json_decode($oldChinchilla->babyPhotos);

        forEach ($oldChinchilla->adultPhotos as $photo) {
            if(in_array($photo, $chinchilla['adultPhotos'])) {
                Storage::disk('public_photos')->delete($photo);
            }
        }
        forEach ($chinchilla['adultPhotos'] as $photo) {
            if(in_array($photo, $oldChinchilla->adultPhotos)) {
                try {
                    Storage::disk('public_photos_root')->move('temporary/'.$photo, 'chinchillas/'.$photo);
                } catch (FileNotFoundException $e) {}
            }
        }

        forEach ($oldChinchilla->babyPhotos as $photo) {
            if(in_array($photo, $chinchilla['babyPhotos'])) {
                Storage::disk('public_photos')->delete($photo);
            }
        }
        forEach ($chinchilla['babyPhotos'] as $photo) {
            if(in_array($photo, $oldChinchilla->babyPhotos)) {
                try {
                    Storage::disk('public_photos_root')->move('temporary/'.$photo, 'chinchillas/'.$photo);
                } catch (FileNotFoundException $e) {}
            }
        }

        $chinchilla['adultPhotos'] = json_encode($chinchilla['adultPhotos']);
        $chinchilla['babyPhotos'] = json_encode($chinchilla['babyPhotos']);
        DB::table("chinchillas")->where('id', $id)->update($chinchilla);
        $chinchilla['adultPhotos'] = json_decode($chinchilla['adultPhotos']);
        $chinchilla['babyPhotos'] = json_decode($chinchilla['babyPhotos']);
        return $chinchilla;
    }

    function delete($id) {
        DB::table('chinchillas')->where('id', $id)->delete();
        return ['success' => true];
    }

    function addAll(Request $request) {
        foreach ($request->all() as $chinchilla) {
            $chinchilla['adultPhotos'] = json_encode($chinchilla['adultPhotos']);
            $chinchilla['babyPhotos'] = json_encode($chinchilla['babyPhotos']);
            DB::table("chinchillas")->insert($chinchilla);
        }
        return Chinchilla::all();
    }

    function deleteAll(Request $request) {
        DB::table('chinchillas')->delete();
        return Chinchilla::all();
    }
}
