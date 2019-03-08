<?php

namespace App\Http\Controllers;

use App\Models\ContactOwner;
use App\Http\Resources\ContactOwnerResource;
use App\Http\Resources\ContactOwnersResource;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactOwner  $contactOwner
     * @return \Illuminate\Http\Response
     */
    public function show(ContactOwner $contactOwner)
    {
        ContactOwnerResource::withoutWrapping();
        return new ContactOwnerResource($contactOwner);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactOwner  $contactOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactOwner $contactOwner)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactOwner  $contactOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactOwner $contactOwner)
    {
        //
    }
}
