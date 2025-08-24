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
        'borrower_contact',
        'start_date',
        'end_date',
        'purpose',
        'location_type',
        'destination',
        'unit_count',
        'vehicles_data',
        'surat_permohonan',
        'surat_tugas',
        'status',
        'notes',
        'checked_out_at',
        'checked_in_at',
        'checked_out_by',
        'checked_in_by',
        'checkout_notes',
        'checkin_notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'unit_count' => 'integer',
        'checked_out_at' => 'datetime',
        'checked_in_at' => 'datetime',
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

    public function checkedOutBy()
    {
        return $this->belongsTo(User::class, 'checked_out_by');
    }

    public function checkedInBy()
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }

    /**
     * Check if borrowing is active
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['approved', 'in_use']);
    }

    /**
     * Check if can be checked out
     */
    public function canCheckOut(): bool
    {
        return $this->status === 'approved' && !$this->checked_out_at;
    }

    /**
     * Check if can be checked in
     */
    public function canCheckIn(): bool
    {
        return $this->status === 'in_use' && $this->checked_out_at && !$this->checked_in_at;
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

    public function scopeReadyForCheckout($query)
    {
        return $query->where('status', 'approved')->whereNull('checked_out_at');
    }

    public function scopeInUse($query)
    {
        return $query->where('status', 'in_use')->whereNotNull('checked_out_at')->whereNull('checked_in_at');
    }

    public function scopeAwaitingReturn($query)
    {
        return $query->where('status', 'in_use')->whereNotNull('checked_out_at')->whereNotNull('checked_in_at');
    }

    public function scopeNotReturned($query)
    {
        return $query->where('status', '!=', 'returned');
    }

    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }

    /**
     * Get formatted duration of borrowing
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->start_date || !$this->returned_at) {
            return '-';
        }

        $start = \Carbon\Carbon::parse($this->start_date);
        $end = \Carbon\Carbon::parse($this->returned_at);

        $diffInDays = $start->diffInDays($end);

        // If less than 1 day, show in hours
        if ($diffInDays < 1) {
            $diffInHours = $start->diffInHours($end);
            if ($diffInHours < 1) {
                $diffInMinutes = $start->diffInMinutes($end);
                return $diffInMinutes . ' menit';
            }
            return $diffInHours . ' jam';
        }

        // Show in days, rounded to whole number
        return round($diffInDays) . ' hari';
    }
}
