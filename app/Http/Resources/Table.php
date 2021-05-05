<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Table extends JsonResource
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
            'close' => $this->close,
            'owner' => new UserResource($this->user),
            'post'=>[
                'id'=>$this->post[0]->id,
                'img_path'=>$this->post[0]->img_path,
            ],
            'created_at'=>$this->created_at->format('m月d日')
        ];
    }
}
