<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrajectResource extends JsonResource
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
            'bus_school_id' => $this->bus_school_id,
            'school_id' => $this->school_id,
            'geometry' => $this->geometry,
            'stops' => $this->stops,
            'type' => $this->type

        ];
    }
}
