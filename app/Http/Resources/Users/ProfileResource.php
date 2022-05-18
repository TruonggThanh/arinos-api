<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'id' => $this->resource->id,
            'companyId' => $this->resource->company_id,
            'visitingCardId' => $this->resource->visiting_card_id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'roleId' => $this->resource->role_id,
            'sex' => $this->resource->sex,
            'dateOfBirth' => $this->resource->date_of_birth,
            'status' => $this->resource->status,
            'isDeleted' => $this->resource->is_deleted
        ];
    }
}
