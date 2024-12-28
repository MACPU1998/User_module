<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * @param string $slug
     */
    public function getPDF($slug)
    {
        $pdf = Storage::disk('local')->get($slug );
        return response()->make($pdf, 200, ['content-type' => 'application/pdf']);
    }
    /**
     * @param string $fileName
     */
    public function getFile($fileDir,$fileName)
    {
        $path = $fileDir."/".$fileName;
        if (Storage::disk('local')->exists($path)) {
            $image = Storage::response($path);

            return $image;
        }
        return response()->noContent(404);

    }

}
