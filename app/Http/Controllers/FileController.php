<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileController extends Controller
{

    function uploadFile(FormRequest $request) {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,jpg,png'],
        ]);

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
        return false;
    }

    function sendBackMessage(Request $request) {
        $to_name = 'Radmila';
        $to_email = 'rada742008@yandex.ru';
        $data = [
            'userName' => $request->all()['userName'],
            'userEmail' => $request->all()['userEmail'],
            'userPhone' => $request->all()['userPhone'],
            'userCity' => $request->all()['userCity'],
            'userMessage' => $request->all()['userMessage']
        ];
        Mail::send('email', $data, function(Message $message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Вопрос с сайта br-chinchillas.ru');
            $message->from('brchinchillasnvrsk@gmail.com', 'Вопрос с сайта');
        });
        return response()->json(["result" => true]);
    }
}
