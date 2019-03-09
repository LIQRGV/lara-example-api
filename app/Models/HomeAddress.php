<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeAddress extends Model
{
    protected $fillable = [
        'contact_owner_id', 'home_address',
    ];
}
