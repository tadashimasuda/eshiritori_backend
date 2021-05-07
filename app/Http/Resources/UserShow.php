<?php

namespace App\Http\Resources;

use App\Http\Resources\Post as PostResource;
use App\Http\Resources\Table as TableResource;
use Illuminate\Http\Resources\Json\JsonResource;
class UserShow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return[
            'user'=>[
                'id'=>$this->id,
                'name'=>$this->name,
                'img_path'=>$this->img_path,
                'profile'=>$this->profile,
                'twitter_id'=>$this->twitter_id
            ],
            'posts'=>PostResource::collection($this->post),
            'tables'=>TableResource::collection($this->table),
        ];
    }
}
