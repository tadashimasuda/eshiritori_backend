<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table;

class TableController extends Controller
{
    public function store(Request $request,Table $table){
        $table = new Table;
		$table->name = $request->name;
        // $table->user()->associate($request->user());
        $table->owner_id = $request->user()->id;
        $table->save();

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
}
