<?php
namespace App\Extensions;

use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class HeaderUserProvider implements UserProvider
{
    private $model;

    /**
     * Create a new user provider.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable|null
     * @return void
     */
    public function __construct(\App\Models\ContactOwner $userModel)
    {
        $this->model = $userModel;
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    { return null; }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials  Request credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, Array $credentials)
    { return true; }

    public function retrieveById($identifier) {}

    public function retrieveByToken($identifier, $token) {}

    public function updateRememberToken(Authenticatable $user, $token) {}
}
