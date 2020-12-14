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
        return 'success';
    }
    public function update(Request $request,Table $table){
        $table = Table::find($request->id);
        //if $table->owner_id == $request->user()->id
        if ($table->owner_id !== $request->user()->id) {
            return 'error';
        }
        $table ->update([
            'close' => 1
        ]);
        return 'success';
    }
}
