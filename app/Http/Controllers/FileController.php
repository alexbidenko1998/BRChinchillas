<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileController extends Controller
{
    function uploadFile(Request $request) {
        foreach ($request->allFiles() as $file) {
            $path = '' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('', $path, 'public_uploads_employee');
            return ['filename' => $path];
        }
        return ['filename' => ''];
    }
}
