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

    protected $fillable = [
        'client_id',
        'title',
        'description',
        'category_id',
        'project_length',
        'budget',
        'payment_preference'
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
}

