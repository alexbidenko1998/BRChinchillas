<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    function uploadFile(Request $request) {
        $path = '' . time() . '_' . Str::random(8) . '.' . $request->file('photo')->getClientOriginalExtension();
        $request->file('photo')->storeAs('', $path, 'public_temporary_photos');
        return ['filename' => $path];
    }

    function getFile($filename) {
        if(Storage::disk('public_temporary_photos')->exists($filename)) {
            return Storage::disk('public_temporary_photos')->download($filename);
        } elseif(Storage::disk('public_photos')->exists($filename)) {
            return Storage::disk('public_photos')->download($filename);
        } else {
            abort(404);
        }
    }
}
