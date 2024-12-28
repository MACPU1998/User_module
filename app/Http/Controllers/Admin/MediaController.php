<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    public function storeMedia(Request $request)
    {
        $path = storage_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    /**
     * @param $directory
     * @param $mediaName
     * @return Response|StreamedResponse
     */
    public function getMedia($directory, $mediaName): Response|StreamedResponse
    {
        $path = storage_path("media/".$directory."/".$mediaName);
        if (Storage::disk('local')->exists($path)) {
            $image = Storage::response($path);

            return $image;
        }
        return response()->noContent(404);

    }

}
