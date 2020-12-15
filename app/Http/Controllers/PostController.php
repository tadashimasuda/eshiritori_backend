<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;

class PostController extends Controller
{
    public function store(Request $request,Post $post)
    {
        return $request;
    }

    public function index(){
        $post = Post::all();
        return  PostResource::collection($post);
    }
}
