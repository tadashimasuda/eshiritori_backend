<?php
namespace App\Http\Controllers;

use App\Post;
use Storage;
use Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Resources\Post as PostResource;
use Prophecy\Exception\Doubler\ReturnByReferenceException;

class PostController extends Controller
{
    public function store(PostRequest $request,Post $post)
    {
        //get all
        $params = $request->json()->all();

        //image
        list(, $image) = explode(';', $params['image']);
        list(, $image) = explode(',', $image);
        $decodedImage = base64_decode($image);

        $user_id = $request->user()->id;
        $table_id = $params['table_id'];

        DB::transaction(function () use ($decodedImage,$user_id,$table_id){
            $id = Str::uuid();
            $file = $id->toString();

            Post::create([
                'user_id' => $user_id,
                'table_id' => $table_id,
                'img_path'=>$file
            ]);

            $isSuccess = Storage::disk('s3')->put('post/'.$file, $decodedImage);
            if (!$isSuccess) {
                throw new Exception('ファイルのアップでエラー');
            }
            Storage::disk('s3')->setVisibility('post/'.$file,'public');
        });
        
        return response('success');
    }

    public function index(Request $request){
        if($request->q ==='top'){
            $posts = Post::limit(5)->get();
            return  PostResource::collection($posts);
        }
        $posts = Post::all();
        return  PostResource::collection($posts);
    }
    public function show(Request $request){
        $post = Post::find($request->id);
        // return new PostResource($post);
    }
}
