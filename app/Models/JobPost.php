<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $table = 'job_posts';
    protected $primaryKey = 'jobPostId';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $dates = ['deadline'];

    protected $fillable = [
        'client_id',
        'title',
        'description',
        'category_id',
        'project_length',
        'budget',
        'payment_preference',
        'deadline'
    ];

    public function skills()
    {
        return $this->belongsToMany(
            Skill::class,
            'job_post_skill',
            'job_post_id',
            'skill_id'
        );
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'categoryId');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'clientId'); 
    }

    /**
     * Get all applications for this job post
     */
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_post_id', 'jobPostId');
    }

    /**
     * Get the accepted application for this job post
     */
    public function acceptedApplication()
    {
        return $this->hasOne(JobApplication::class, 'job_post_id', 'jobPostId')
                    ->where('status', 'accepted');
    }

}

