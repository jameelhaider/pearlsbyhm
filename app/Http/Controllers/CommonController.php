<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CommonController extends Controller
{
    public static function imgUpload($picture, $path, $previousImagePath = null)
    {
        $uploadPath = public_path('uploads/' . trim($path, '/'));
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }
        if (!is_null($previousImagePath)) {
            $oldFilePath = public_path($previousImagePath);
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }
        }
        $ext = $picture->getClientOriginalExtension();
        $fileName = uniqid(time() . '_') . '.' . $ext;
        $picture->move($uploadPath, $fileName);
        return 'uploads/' . trim($path, '/') . '/' . $fileName;
    }
}
