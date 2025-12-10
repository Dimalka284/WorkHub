<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'delivery_url',
        'delivery_files',
        'delivery_message',
        'revision_number',
        'status'
    ];

    protected $casts = [
        'delivery_files' => 'array',
    ];

    // Relationship
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
