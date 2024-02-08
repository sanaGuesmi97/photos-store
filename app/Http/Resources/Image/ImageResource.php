<?php

namespace App\Http\Resources\Image;

use App\Http\Resources\Categories\CategoriesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "description" => $this->description,
            "price" => $this->price,
            "categories" => new CategoriesResource($this->categories),
            "user" => $this->user,
            "increment" => $this->increment,
            "file" => $this->image
        ];
    }
}
