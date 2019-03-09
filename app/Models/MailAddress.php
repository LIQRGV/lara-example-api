<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailAddress extends Model
{
    protected $fillable = [
        'contact_owner_id', 'email',
    ];
}
