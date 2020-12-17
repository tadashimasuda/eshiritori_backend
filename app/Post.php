<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id','table_id','img_path'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
