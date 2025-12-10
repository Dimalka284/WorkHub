<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gig extends Model
{
    use HasFactory;
    protected $fillable = [
        'freelancer_id', 'display_name', 'profileimg', 'description', 'college', 'linkedin', 'git'
    ];

    public function freelancer() {
        return $this->belongsTo(Freelancer::class, 'freelancer_id', 'freelancerId');
    }

    public function skills() {
        return $this->belongsToMany(Skill::class, 'gig_skill', 'gig_id', 'skillId')
                    ->withPivot('experienceLevel')
                    ->withTimestamps();
    }

    public function orders() {
        return $this->hasMany(Order::class, 'gig_id', 'id');
    }
}
