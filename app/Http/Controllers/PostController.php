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
use Abraham\TwitterOAuth\TwitterOAuth;

class PostController extends Controller
{
    public function store(PostRequest $request,Post $post){
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

            $post_id = Post::create([
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
        $post = Post::latestFirst()->first();
        return response()->json([
            'post_id'=> $post->id
        ],200);
    }
    public function index(Request $request){
        if($request->q ==='top'){
            $posts = Post::latestFirst()->offset(1)->limit(5)->get();
            return  PostResource::collection($posts);
        }elseif ($request->table) {
            $table_id = $request->table;
            $posts_check = Post::where('table_id',$table_id)->exists();
            if ($posts_check) {
                // $posts = Post::where('table_id',$table_id)->latestFirst()->paginate(5)->appends(array('table'=>$table_id));
                $posts = Post::where('table_id',$table_id)->latestFirst()->get();
                return  PostResource::collection($posts);
            }else{
                return response()->json(['message' => 'not data'],404);
            }
        }
        $posts = Post::all();
        return  PostResource::collection($posts);
    }
    public function show(Request $request){
        //table_id中のpostで最新のid取得
        $post = Post::LatestFirstTablePost($request->id);
        return response()->json([
            'id' => $post->id,
            'table_id' => $post->table_id,
            'img_path' => $post->img_path,
        ]);
    }
}
