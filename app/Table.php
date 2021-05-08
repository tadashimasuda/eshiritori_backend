<?php

namespace App;
use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use Orderable;
    protected $fillable = [
        'id','name','owner_id','close'
    ];

    public function scopeOwnerId($query,$str){
      return $query->where('owner_id',$str);
    }
    public function user() {
		  return $this->belongsTo(User::class,'owner_id');
    }
    public function post() {
      return $this->hasMany(Post::class);
    }
}
