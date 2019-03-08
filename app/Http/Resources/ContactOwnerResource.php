<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactOwnerResource extends JsonResource
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
            'type'          => 'contact_owner',
            'id'            => (string)$this->id,
            'attributes'    => [
                'full_name' => $this->full_name,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => new ContactOwnerRelationshipResource($this),
            'links' => [
                'self' =>  route('contacts.show', $this->id)
            ],
        ];
    }
}
