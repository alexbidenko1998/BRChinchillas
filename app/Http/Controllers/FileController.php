<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    function uploadFile(Request $request) {
//        $request->validate([
//            'photo' => ['required', 'image', 'mimes:jpeg,jpg,png'],
//        ]);
//        $info = pathinfo($_FILES['photo']['name']);
//        $path = '' . time() . '_' . Str::random(8) . '.' . $info['extension'];
//        move_uploaded_file($_FILES['photo']['tmp_name'], public_path('photos/temporary'));

        $path = '' . time() . '_' . Str::random(8) . '.png'/* . $request->photo->getClientOriginalExtension()*/;
//        $request->photo->storeAs('', $path, 'public_temporary_photos');

        $data = substr($request->photo, strpos($request->photo, ','));

        $data = base64_decode($data);
        Storage::disk('public_temporary_photos')->put($path, $data);
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
