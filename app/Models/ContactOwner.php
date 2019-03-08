<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ContactOwner extends Authenticatable
{
    protected $fillable = [
        'id', 'full_name',
    ];


    public function homeAddresses() {
        return $this->hasMany('App\Models\HomeAddress');
    }

    public function mailAddresses() {
        return $this->hasMany('App\Models\MailAddress');
    }

    public function phoneNumbers() {
        return $this->hasMany('App\Models\PhoneNumber');
    }
}

