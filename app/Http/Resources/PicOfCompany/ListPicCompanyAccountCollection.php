<?php

namespace App\Http\Resources\PicOfCompany;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ListPicCompanyAccountCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ListPicCompanyAccountResource::collection($this->collection);
    }
}
