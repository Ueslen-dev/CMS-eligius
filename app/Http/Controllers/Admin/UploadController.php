<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function uploadimage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png|max:1000'
        ]);
        $hashImage = time().'.'.$request->file->extension();
        $request->file->move(public_path('media/images'), $hashImage);

        return [
            'location' => asset('media/images/'.$hashImage)
        ];
    }
}
