<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'service_type',
        'payment_type',
        'damage_description',
        'repair_description',
        'parts_replaced',
        'description',
        'documents',
        'photos',
        'service_date',
    ];

    protected $casts = [
        'service_date' => 'date',
        'documents' => 'array',
        'photos' => 'array',
        'payment_type' => 'string',
    ];

    /**
     * Relationships
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scopes
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
