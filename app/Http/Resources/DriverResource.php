<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'id' => $this->user->id,
            'school_id' => $this->school_id,
            'bus_school_id' => $this->bus_school_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'cin' => $this->cin,
            'profile_id' => $this->user->profile_id,
            'user_type' => $this->user->user_type
        ];
    }
}
