<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileController extends Controller
{
    function uploadFile(Request $request) {
        $path = ''.time().'_'.Str::random(8).'.'.$request->file('file')->getClientOriginalExtension();
        $request->file('file')->storeAs('', $path, 'public_uploads_employee');
        return ['filename' => $path];
    }
}
