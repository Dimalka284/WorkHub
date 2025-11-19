<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $table = 'clients';
    protected $primaryKey = 'clientId';

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'profilePic',
        'companyName',
        'companyDescription',
        'industryId'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
