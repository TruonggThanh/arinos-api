<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'companyId' => $this->company_id,
            'visitingCardId' => $this->visiting_card_id,
            'name' => $this->name,
            'sex' => $this->sex,
            'roleId' => $this->role_id,
            'email' => $this->email,
            'phone' => $this->phone, 
            'status' => $this->status, 
        ];
    }
}
