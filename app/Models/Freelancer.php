<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Freelancer extends Authenticatable
{
    use Notifiable;

    protected $table = 'freelancer';
    protected $primaryKey = 'freelancerId'; // your actual primary key column
    public $incrementing = false;           // if it’s not auto-increment
    protected $keyType = 'string';  

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'profilePic',
        'bio',
        'linkedInprofile'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get all job applications submitted by this freelancer
     */
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'freelancer_id', 'freelancerId');
    }
}
