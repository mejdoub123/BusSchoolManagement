<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanningResource extends JsonResource
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
            'monday_go_at' => $this->monday_go_at,
            'monday_comeback_at' => $this->monday_comeback_at,
            'tuesday_go_at' => $this->tuesday_go_at,
            'tuesday_comeback_at' => $this->tuesday_comeback_at,
            'wednesday_go_at' => $this->wednesday_go_at,
            'wednesday_comeback_at' => $this->wednesday_comeback_at,
            'thursday_go_at' => $this->thursday_go_at,
            'thursday_comeback_at' => $this->thursday_comeback_at,
            'friday_go_at' => $this->friday_go_at,
            'friday_comeback_at' => $this->friday_comeback_at,
        ];
    }
}
