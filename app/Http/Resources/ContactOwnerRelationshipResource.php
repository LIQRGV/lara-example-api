<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactOwnerRelationshipResource extends JsonResource
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
            'home_address' => [
                'links' => [
                    'self' => route('contacts.relationships.home_address', ['contact' => $this->id]),
                ],
                'data' => new HomeAddressesResource($this->homeAddresses),
            ],
            'mail_address' => [
                'links' => [
                    'self' => route('contacts.relationships.mail_address', ['contact' => $this->id]),
                ],
                'data' => new MailAddressesResource($this->MailAddresses),
            ],
            'phone_number' => [
                'links' => [
                    'self' => route('contacts.relationships.phone_number', ['contact' => $this->id]),
                ],
                'data' => new PhoneNumbersResource($this->phoneNumbers),
            ],
        ];

    }
}
