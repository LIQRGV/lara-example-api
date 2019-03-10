<?php

namespace App\Http\Controllers;

use App\Models\ContactOwner;
use App\Http\Services\ContactOwnerService;
use App\Http\Resources\ContactOwnerResource;
use App\Http\Resources\ContactOwnersResource;
use Illuminate\Http\Request;

use App\Helpers\ResourceHelper;

class ContactOwnerController extends Controller
{
    private $contactOwnerService;

    public function __construct(ContactOwnerService $contactOwnerService) {
        $this->contactOwnerService = $contactOwnerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rawFilter = $request->query->get('filter');
        $ordering = $request->query->get('orderBy');
        return $this->contactOwnerService->index($rawFilter, $ordering);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $jsonRequest = $request->json();
        $jsonId = $jsonRequest->get('id');
        if ($this->isNotContactOwner($request) || $this->idNotMatch($jsonId, $id)) {
            return response(null,400);
        }

        return $this->contactOwnerService->store($jsonRequest, $jsonId);
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
            return $this->contactOwnerService->show($contactOwner);
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
                return response(null,400);
            }

            return $this->contactOwnerService->update($jsonRequest, $jsonId);
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
}
