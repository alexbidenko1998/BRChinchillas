<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileController extends Controller
{
    function uploadFile(Request $request) {
        $path = '' . time() . '_' . Str::random(8) . '.' . $request->file('photo')->getClientOriginalExtension();
        $request->file('photo')->storeAs('', $path, 'public_temporary_photos');
        return ['filename' => $path];
    }
}
