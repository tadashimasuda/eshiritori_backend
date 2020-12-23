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
            'owner' => new UserResource($this->user),
            'post'=>[
                'id'=>$this->post[0]->id,
                'img_path'=>$this->post[0]->img_path,
            ]
        ];
    }
}
