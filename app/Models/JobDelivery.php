<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'delivery_url',
        'delivery_files',
        'delivery_message',
        'revision_number',
        'status'
    ];

    protected $casts = [
        'delivery_files' => 'array',
    ];

    /**
     * Get the job application this delivery belongs to
     */
    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id', 'id');
    }
}
