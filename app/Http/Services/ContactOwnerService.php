<?php

namespace App\Http\Services;

use App\Models\ContactOwner;
use App\Http\Resources\ContactOwnerResource;
use App\Http\Resources\ContactOwnersResource;
use Illuminate\Http\Request;

use App\Helpers\ResourceHelper;

class ContactOwnerService
{
    public function index($rawFilter, $ordering)
    {
        $sanitizedFilter = $this->sanitizeArrayForModel($rawFilter, ContactOwner::class);
        $sanitizedOrder = $this->sanitizeArrayForModel($ordering, ContactOwner::class);

        $filters = $this->translateFilter($sanitizedFilter);
        $contactOwner = ContactOwner::with(
            'homeAddresses',
            'mailAddresses',
            'phoneNumbers'
        );

        if(!empty($filters)) {
            $contactOwner->where($filters);
        }

        if(!empty($sanitizedOrder)) {
            foreach($sanitizedOrder as $field => $order) {
                if("" == $order) {
                    $order = "ASC";
                }
                $contactOwner->orderBy($field, $order);
            }
        }

        return new ContactOwnersResource($contactOwner->paginate());
    }

    public function store($jsonRequest, $jsonId)
    {
        $mainDatum = [
            'type' => $jsonRequest->get('type'),
            'id' => $jsonId,
            'attributes' => $jsonRequest->get('attributes'),
        ];

        $contactOwner = ResourceHelper::toResource($mainDatum);

        \DB::transaction(function() use ($contactOwner, $jsonRequest) {
            $contactOwner->save();
            if(!empty($jsonRequest->get('relationships'))) {
                $contactOwner = $this->includeRelationship($contactOwner, $jsonRequest->get('relationships'));
            }
        });

        return new ContactOwnerResource($contactOwner);
    }

    public function show(ContactOwner $contactOwner)
    {
        return new ContactOwnerResource($contactOwner);
    }

    public function update($jsonRequest, $jsonId)
    {
        $mainDatum = [
            'type' => $jsonRequest->get('type'),
            'id' => $jsonId,
            'attributes' => $jsonRequest->get('attributes'),
        ];

        $contactOwner = ResourceHelper::toResource($mainDatum);
        $contactOwner->exists = true;

        \DB::transaction(function() use ($contactOwner, $jsonRequest) {
            $contactOwner->save();
            $contactOwner = $this->includeRelationship($contactOwner, $jsonRequest->get('relationships'));
        });

        return new ContactOwnerResource($contactOwner);
    }

    public function destroy(ContactOwner $contactOwner)
    {
        if(\Auth::user()->can('delete', $contactOwner)) {
            $contactOwner->delete();

            return response(null, 204);
        } else {
            return response(null, 401);
        }
    }

    private function sanitizeArrayForModel($sourceArray, $modelClass) {
        if(is_null($sourceArray)) {
            return array();
        }

        $model = new $modelClass();
        $allowedField = $model->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($model->getTable());

        return array_filter(
            $sourceArray,
            function ($key) use ($allowedField) {
                return in_array($key, $allowedField);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    private function translateFilter($filter) {
        $operatorMap = [
            'is' => '=',
            'not' => '<>',
            'like' => 'like',
            'gte' => '>=',
            'lte' => '<=',
            'gt' => '>',
            'lt' => '<',
        ];

        $tidiedFilter = array();

        foreach($filter as $key => $value) {
            $convertedArray;
            if(is_array($value)) {
                foreach($value as $operator => $targetValue) {
                    $convertedArray = [$key, $operatorMap[$operator], $targetValue];
                }
            } else {
                $convertedArray = [$key, $value];
            }
            array_push($tidiedFilter, $convertedArray);
        }

        return $tidiedFilter;
    }

    private function includeRelationship($contactOwner, $relationshipArray) {
        $allRelation = array_reduce($relationshipArray, function($current, $reducedValue) {
            return array_merge($current, $reducedValue['data']);
        }, array());

        $mapRelationshipName = [
            'home_address' => 'homeAddresses',
            'mail_address' => 'mailAddresses',
            'phone_number' => 'phoneNumbers',
        ];

        foreach($allRelation as $relation) {
            $type = $relation['type'];
            $relationshipName = $mapRelationshipName[$type];

            $relation['attributes']['contact_owner_id'] = $contactOwner->id;
            $obj = ResourceHelper::toResource($relation);
            $obj->save();
        }

        return $contactOwner;
    }
}

