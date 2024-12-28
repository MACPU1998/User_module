<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download($token)
    {
        $path = decrypt($token);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->download($path);
    }
}
