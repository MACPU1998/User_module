<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Blog;
use Illuminate\Support\Facades\Request;
use Response;

class BlogController extends ApiController
{
    public function blogs()
    {
        $blogs = Blog::where("status",1)
            ->select("id","title","summary","thumbnail")
            ->get();
        return Response::success(data: $blogs);
    }

    public function post($post_id)
    {
        $post = Blog::find($post_id)->where("status",1)
            ->select("id","title","thumbnail","content","created_at")
            ->get();
        return Response::success(data: $post);
    }
}
