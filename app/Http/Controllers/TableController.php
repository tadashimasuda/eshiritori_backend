<?php

namespace App\Http\Controllers;

use App\Http\Resources\Table as TableResource;
use App\Http\Resources\TableShow as TableShowResource;
use App\Http\Requests\PostTableRequest;
use Illuminate\Http\Request;
use App\Table;
use App\Post;
use Storage;
use Str;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function store(PostTableRequest $request,Table $table){

        //get all
        $params = $request->json()->all();

        //image
        list(, $image) = explode(';', $params['image']);
        list(, $image) = explode(',', $image);
        $decodedImage = base64_decode($image);

        $name = $request->name;
        $user_id = $request->user()->id;

        DB::transaction(function () use ($name,$decodedImage,$user_id){
            // $table = new Table;
            // $table->name = $name;
            // $table->owner_id = $user_id;
            // $table->save();
            $table = Table::create([
                'name' => $name,
                'owner_id' => $user_id,
            ]);

            $id = Str::uuid();
            $file = $id->toString();

            Post::create([
                'user_id' => $user_id,
                'table_id' => $table->id,
                'img_path'=>$file
            ]);

            $isSuccess = Storage::disk('s3')->put('post/'.$file, $decodedImage);
            if (!$isSuccess) {
                throw new Exception('ファイルのアップでエラー');
            }
            Storage::disk('s3')->setVisibility('post/'.$file,'public');
    
        });

        return response()->json([
            'message'=>'success'
        ],200);
        
    }
    public function update(Request $request,Table $table){
        $table = Table::find($request->id);
        //if $table->owner_id == $request->user()->id
        if ($table->owner_id !== $request->user()->id) {
            return response()->json([
                'message'=>'ユーザー情報とテーブルオーナー情報が一致しません'
            ],400);
        }
        $table ->update([
            'close' => 1
        ]);

        return response()->json([
            'message'=>'success'
        ],200);
    }
    public function index(Request $request)
    {
        if($request->q ==='top'){
            $tables = Table::latestFirst()->offset(1)->limit(5)->get();
            return  TableResource::collection($tables);
        }
        $tables = Table::all();
        return  TableResource::collection($tables);
    }
    public function show(Request $request){
        $table = Table::find($request->id);
        return new TableResource($table);
    }
    public function user(Request $request)
    {
        $tables = Table::where('owner_id',$request->id)->get();
        return  TableResource::collection($tables);
    }
}
