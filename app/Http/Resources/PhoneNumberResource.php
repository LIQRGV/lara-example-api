<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhoneNumberResource extends JsonResource
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
            'type'          => 'phone_number',
            'id'            => (string)$this->id,
            'attributes'    => [
                'phone_number' => $this->phone_number,
            ],
        ];
    }
}
