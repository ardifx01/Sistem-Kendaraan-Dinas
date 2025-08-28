<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Resolve route binding to include trashed models so implicit
     * route-model binding can fetch soft-deleted Service records.
     *
     * This allows routes/controllers that type-hint Service to
     * receive a trashed instance (so show/edit won't 404 after soft-delete).
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $field = $field ?? $this->getRouteKeyName();
        return $this->withTrashed()->where($field, $value)->first();
    }

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
    'license_plate',
    'brand',
    'model',
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
    return $this->hasMany('App\\Models\\Payment');
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