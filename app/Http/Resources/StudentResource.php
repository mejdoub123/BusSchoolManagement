<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'name' => $this->user->name,
            'email' => $this->user->email,
            'id' => $this->user->id,
            'school_id' => $this->school_id,
            'bus_school_id' => $this->bus_school_id,
            'zone_id' => $this->zone_id,
            'cne' => $this->cne,
            'address' => $this->address,
            'address_position' => $this->address_position,
            'phone_number' => $this->phone_number,
            'profile_id' => $this->user->profile_id,
            'user_type' => $this->user->user_type
        ];
    }
}
