<?php

namespace App\Helpers;

use App\Models\ContactOwner;
use App\Models\HomeAddress;
use App\Models\MailAddress;
use App\Models\PhoneNumber;

class ResourceHelper
{
    public static function toResource($datumToConvert) {
        $resourceTypeToMap = [
            'contact_owner' => ContactOwner::class,
            'home_address' => HomeAddress::class,
            'mail_address' => MailAddress::class,
            'phone_number' => PhoneNumber::class,
        ];

        $datumType = $datumToConvert['type'];
        $classToInstantiate = $resourceTypeToMap[$datumType];
        $obj = new $classToInstantiate;
        if(isset($datumToConvert['id'])) {
            $obj->id = $datumToConvert['id'];
        }
        $obj->forceFill($datumToConvert['attributes']);

        return $obj;
    }
}

