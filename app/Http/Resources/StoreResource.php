<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'image'        => $this->image,
            'phone_number'        => $this->phone_number,
            'title'       => $this->title,
            'description' => $this->description,
            'country_code'     => $this->country_code,
            'merchant'    => UserResource::make($this->merchant),
        ];
    }
}
