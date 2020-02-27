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
        return Chinchilla::all();
    }

    function add(Request $request) {
        return Chinchilla::create($request->all());
    }

    function update($id, Request $request) {
        $chinchilla = $request->all();
        $oldChinchilla = Chinchilla::whereId($id)->first();

        forEach ($oldChinchilla->adultPhotos as $photo) {
            if(!in_array($photo, $chinchilla['adultPhotos'])) {
                Storage::disk('public_photos')->delete($photo);
            }
        }
        forEach ($chinchilla['adultPhotos'] as $photo) {
            if(!in_array($photo, $oldChinchilla->adultPhotos)) {
                if(Storage::disk('public_temporary_photos')->exists($photo)) {
                    Storage::disk('public_photos_root')->move('temporary/'.$photo, 'chinchillas/'.$photo);
                }
            }
        }

        forEach ($oldChinchilla->babyPhotos as $photo) {
            if(!in_array($photo, $chinchilla['babyPhotos'])) {
                Storage::disk('public_photos')->delete($photo);
            }
        }
        forEach ($chinchilla['babyPhotos'] as $photo) {
            if(!in_array($photo, $oldChinchilla->babyPhotos)) {
                if(Storage::disk('public_temporary_photos')->exists($photo)) {
                    Storage::disk('public_photos_root')->move('temporary/'.$photo, 'chinchillas/'.$photo);
                }
            }
        }

        $chinchilla['adultPhotos'] = json_encode($chinchilla['adultPhotos']);
        $chinchilla['babyPhotos'] = json_encode($chinchilla['babyPhotos']);
        DB::table("chinchillas")->where('id', $id)->update($chinchilla);

        return Chinchilla::whereId($id)->first();
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
