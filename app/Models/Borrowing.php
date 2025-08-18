<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'user_id',
        'borrower_type',
        'borrower_name',
        'start_date',
        'end_date',
        'purpose',
        'location_type',
        'destination',
        'unit_count',
        'request_letter',
        'statement_letter',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'unit_count' => 'integer',
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

    /**
     * Check if borrowing is active
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['approved', 'in_use']);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['approved', 'in_use']);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}