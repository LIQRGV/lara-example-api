<?php

namespace App\Policies;

use App\Models\ContactOwner;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactOwnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the contact owner.
     *
     * @param  \App\Models\ContactOwner  $user
     * @param  \App\Models\ContactOwner  $contactOwner
     * @return mixed
     */
    public function view(ContactOwner $user, ContactOwner $contactOwner)
    {
        return $user->id == $contactOwner->id;
    }

    /**
     * Determine whether the user can create contact owners.
     *
     * @param  \App\Model\ContactOwner  $user
     * @return mixed
     */
    public function create(ContactOwner $user, $request)
    {
        return true;
    }

    /**
     * Determine whether the user can update the contact owner.
     *
     * @param  \App\Model\ContactOwner  $user
     * @param  \App\ContactOwner  $contactOwner
     * @return mixed
     */
    public function update(ContactOwner $user, ContactOwner $contactOwner)
    {
        return $user->id == $contactOwner->id;
    }

    /**
     * Determine whether the user can delete the contact owner.
     *
     * @param  \App\Model\ContactOwner  $user
     * @param  \App\ContactOwner  $contactOwner
     * @return mixed
     */
    public function delete(ContactOwner $user, ContactOwner $contactOwner)
    {
        return $user->id == $contactOwner->id;
    }
}
