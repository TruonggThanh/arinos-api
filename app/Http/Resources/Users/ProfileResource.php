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
            'id' => $this->id,
            'companyId' => $this->company_id,
            'name' => $this->name,
            'nameRomaji' => $this->name_romaji,
            'email' => $this->email,
            'sex' => $this->sex,
            'dateOfBirth' => $this->date_of_birth,
            'phone' => $this->phone,
            'roleId' => $this->role_id,
            'position' => $this->position,
            'avatar' => $this->avatar,
            'status' => $this->status,
        ];
    }
}
