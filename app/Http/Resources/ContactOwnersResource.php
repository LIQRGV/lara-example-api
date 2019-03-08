<?php

namespace App\Http\Resources;

use App\Models\HomeAddress;
use App\Models\MailAddress;
use App\Models\PhoneNumber;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class ContactOwnersResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ContactOwnerResource::collection($this->collection);
    }

    public function with($request)
    {
        $homeAddresses = $this->collection->flatMap(
            function ($contactOwner) {
                return $contactOwner->homeAddresses;
            }
        );
        $mailAddresses = $this->collection->flatMap(
            function ($contactOwner) {
                return $contactOwner->mailAddresses;
            }
        );
        $phoneNumbers = $this->collection->flatMap(
            function ($contactOwner) {
                return $contactOwner->phoneNumbers;
            }
        );

        $included = $homeAddresses->merge($mailAddresses)->merge($phoneNumbers);
        return [
            'links'    => [
                'self' => route('contacts.index'),
            ],
            'included' => $this->withIncluded($included),
        ];
    }

    private function withIncluded(Collection $included)
    {
        $mappedIncluded =  $included->map(
            function ($include) {
                if ($include instanceof HomeAddress) {
                    return new HomeAddressResource($include);
                }
                if ($include instanceof MailAddress) {
                    return new MailAddressResource($include);
                }
                if ($include instanceof PhoneNumber) {
                    return new PhoneNumberResource($include);
                }
            }
        );

        return $mappedIncluded;
    }
}
