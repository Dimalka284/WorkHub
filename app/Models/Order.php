<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'gig_id',
        'client_id',
        'freelancer_id',
        'status',
        'requirements',
        'budget',
        'deadline'
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    // Relationships
    public function gig()
    {
        return $this->belongsTo(Gig::class, 'gig_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'clientId');
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id', 'freelancerId');
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'order_id', 'id');
    }

    public function latestDelivery()
    {
        return $this->hasOne(Delivery::class, 'order_id', 'id')->latestOfMany();
    }
}
