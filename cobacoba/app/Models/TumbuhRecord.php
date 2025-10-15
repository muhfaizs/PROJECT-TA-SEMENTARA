<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TumbuhRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'anak_id',
        'measured_at',
        'bb_kg',
        'tb_cm',
        'll_cm',
        'status_gizi',
        'posyandu_id',
        'created_by',
        'verified_by',
        'verified_at',
        'reject_reason',
    ];

    protected $casts = [
        'measured_at' => 'date',
        'bb_kg' => 'decimal:2',
        'tb_cm' => 'decimal:2',
        'll_cm' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    /**
     * Get anak
     */
    public function anak()
    {
        return $this->belongsTo(Anak::class);
    }

    /**
     * Get posyandu
     */
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    /**
     * Get user yang membuat record ini
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get user yang memverifikasi record ini
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scope untuk data yang belum diverifikasi
     */
    public function scopeUnverified($query)
    {
        return $query->whereNull('verified_at');
    }

    /**
     * Scope untuk data yang sudah diverifikasi
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }

    /**
     * Check apakah sudah diverifikasi
     */
    public function getIsVerifiedAttribute()
    {
        return !is_null($this->verified_at);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status_gizi) {
            'stunted' => 'danger',
            'wasted' => 'danger',
            'overweight' => 'warning',
            'normal' => 'success',
            default => 'muted',
        };
    }
}
