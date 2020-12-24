<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Table;
use App\Http\Resources\User;
class Post extends JsonResource
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
            'id' => $this->id,
            'table_id' => $this->table_id,
            'img_path' => $this->img_path,
            'user' =>[
                'id'=>$this->user->id,
                'twitter_id'=>$this->user->twitter_id,
                'name'=>$this->user->name,
                'img_path'=>$this->user->img_path,
            ],
            'table' => [
                'id' => $this->table->id,
                'name' => $this->table->name
            ]
        ];
    }
}
