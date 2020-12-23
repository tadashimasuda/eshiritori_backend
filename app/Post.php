<?php

namespace App;
use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Orderable;
    protected $fillable = [
        'user_id','table_id','img_path'
    ];
    public function scopeTableId($query,$str){
        return $query->where('table_id',$str);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function table()
    {
        return $this->belongsTo(Post::class);
    }
}
