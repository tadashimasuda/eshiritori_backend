<?php

namespace App\Http\Resources;

use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TableShow extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->name,
            'owner'=>[
                'id'=>$this->user->id,
                'name'=>$this->user->name,
                'img_path'=>$this->user->img_path,
            ],
            'post'=>PostResource::collection($this->post)
        ];
    }
}
