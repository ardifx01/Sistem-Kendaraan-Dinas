<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'user_id',
        'payment_source',
        'description',
        'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes
     */
    public function scopeBySource($query, $source)
    {
        return $query->where('payment_source', $source);
    }
}