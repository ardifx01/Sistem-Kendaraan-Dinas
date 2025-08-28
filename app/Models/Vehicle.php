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
        'bpkb_number',
        'chassis_number',
        'engine_number',
        'cc_amount',
    ];

    protected $casts = [
        'tax_expiry_date' => 'date',
        'year' => 'integer',
    ];

    public function isTaxExpiringSoon(): bool
    {
        if (!$this->tax_expiry_date) {
            return false;
        }

        $daysUntilExpiry = Carbon::now()->diffInDays(Carbon::parse($this->tax_expiry_date), false);
        return $daysUntilExpiry <= 60; // 2 bulan = 60 hari, termasuk yang sudah expired (negative)
    }

    public function isTaxExpired(): bool
    {
        if (!$this->tax_expiry_date) {
            return false;
        }

        return Carbon::now()->isAfter(Carbon::parse($this->tax_expiry_date));
    }

    /**
     * Get formatted vehicle name
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->model} ({$this->license_plate})";
    }

    /**
     * Get days until tax expiry (negative if expired)
     */
    public function getDaysUntilTaxExpiryAttribute(): int
    {
        if (!$this->tax_expiry_date) {
            return 0;
        }

        return (int) Carbon::now()->diffInDays(Carbon::parse($this->tax_expiry_date), false);
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
     * Get all services including soft-deleted ones.
     * Use this when building history views or admin queries that must include trashed records.
     */
    public function servicesWithTrashed()
    {
        return $this->hasMany(Service::class)->withTrashed();
    }

    /**
     * Get latest service including soft-deleted ones.
     */
    public function latestServiceWithTrashed()
    {
        return $this->hasOne(Service::class)->latest()->withTrashed();
    }

    /**
     * Days since last service (integer). Returns null if no service found.
     */
    public function daysSinceLastService(): ?int
    {
        $latest = $this->latestService()->first();
        if (!$latest || !$latest->service_date) {
            return null;
        }

        return (int) \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($latest->service_date));
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
        return $query->whereDate('tax_expiry_date', '<=', Carbon::now()->addDays(60))
                    ->whereDate('tax_expiry_date', '>=', Carbon::now()->subYears(1));
    }
}
