<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_post_id',
        'freelancer_id',
        'cover_letter',
        'proposed_rate',
        'status',
        'work_status',
        'revisions_used',
        'max_revisions'
    ];

    /**
     * Get the job post that this application belongs to
     */
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_post_id', 'jobPostId');
    }

    /**
     * Get the freelancer who submitted this application
     */
    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id', 'freelancerId');
    }

    /**
     * Get all deliveries for this application
     */
    public function deliveries()
    {
        return $this->hasMany(JobDelivery::class, 'job_application_id', 'id');
    }

    /**
     * Get the latest delivery for this application
     */
    public function latestDelivery()
    {
        return $this->hasOne(JobDelivery::class, 'job_application_id', 'id')->latestOfMany();
    }

    /**
     * Scope to get pending applications
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get accepted applications
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope to get rejected applications
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
