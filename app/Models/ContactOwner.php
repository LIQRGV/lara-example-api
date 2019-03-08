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

    public function delete() {
        foreach($this->homeAddresses as $homeAddressObject) {
            $homeAddressObject->delete();
        }
        foreach($this->mailAddresses as $mailAddressObject) {
            $mailAddressObject->delete();
        }
        foreach($this->phoneNumbers as $phoneNumberObject) {
            $phoneNumberObject->delete();
        }
        parent::delete();
    }
}

