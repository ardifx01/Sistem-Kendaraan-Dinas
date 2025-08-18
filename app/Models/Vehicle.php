<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'brand',
        'model',
        'year',
        'license_plate',
        'color',
        'tax_expiry_date',
        'document_status',
        'document_notes',
        'driver_name',
        'user_name',
        'photo',
        'availability_status',
    ];

    protected $casts = [
        'tax_expiry_date' => 'date',
        'year' => 'integer',
    ];

    /**
     * Check if tax is expiring soon (within 30 days)
     */
    public function isTaxExpiringSoon(): bool
    {
        if (!$this->tax_expiry_date) {
            return false;
        }

        return Carbon::parse($this->tax_expiry_date)->diffInDays(Carbon::now()) <= 30;
    }

    /**
     * Get formatted vehicle name
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->model} ({$this->license_plate})";
    }

    /**
     * Relationships
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Get latest service
     */
    public function latestService()
    {
        return $this->hasOne(Service::class)->latest();
    }

    /**
     * Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('availability_status', 'tersedia');
    }

    public function scopeTaxExpiringSoon($query)
    {
        return $query->whereDate('tax_expiry_date', '<=', Carbon::now()->addDays(30));
    }
}
