<?php

namespace App\Http\Controllers;

use App\Models\ContactOwner;
use App\Http\Resources\ContactOwnerResource;
use App\Http\Resources\ContactOwnersResource;
use Illuminate\Http\Request;

use App\Helpers\ResourceHelper;

class ContactOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ContactOwnersResource::withoutWrapping();
        return new ContactOwnersResource(ContactOwner::with(
            'homeAddresses',
            'mailAddresses',
            'phoneNumbers'
        )->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ContactOwner $contactOwner)
    {
        $jsonRequest = $request->json();
        $jsonId = $jsonRequest->get('id');
        if ($this->isNotContactOwner($request) || $this->idNotMatch($jsonId, $contactOwner->id)) {
            abort(400);
        }

        $mainDatum = [
            'type' => $jsonRequest->get('type'),
            'id' => $jsonId,
            'attributes' => $jsonRequest->get('attributes'),
        ];

        $contactOwner = ResourceHelper::toResource($mainDatum);

        \DB::transaction(function() use ($contactOwner, $jsonRequest) {
            $contactOwner->save();
            $contactOwner = $this->includeRelationship($contactOwner, $jsonRequest->get('relationships'));
        });

        return new ContactOwnerResource($contactOwner);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactOwner  $contactOwner
     * @return \Illuminate\Http\Response
     */
    public function show(ContactOwner $contactOwner)
    {
        if(\Auth::user()->can('view', $contactOwner)) {
            return new ContactOwnerResource($contactOwner);
        } else {
            return response(null, 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactOwner  $contactOwner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactOwner $contactOwner)
    {
        if(\Auth::user()->can('update', $contactOwner)) {
            $jsonRequest = $request->json();
            $jsonId = $jsonRequest->get('id');
            if ($this->isNotContactOwner($request) || $this->idNotMatch($jsonId, $contactOwner->id)) {
                abort(400);
            }

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
        } else {
            return response(null, 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactOwner  $contactOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactOwner $contactOwner)
    {
        if(\Auth::user()->can('delete', $contactOwner)) {
            $contactOwner->delete();

            return response(null, 204);
        } else {
            return response(null, 401);
        }
    }

    private function isNotContactOwner($request) {
        return $request->json()->get('type') != 'contact_owner';
    }

    private function idNotMatch($id, $otherId) {
        return $id != $otherId;
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

            $relation['attributes']['id'] = $relation['id'];
            $relation['attributes']['contact_owner_id'] = $contactOwner->id;

            $contactOwner->{$relationshipName}()->createMany([$relation['attributes']]);
        }

        return $contactOwner;
    }
}
