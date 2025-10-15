<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImunisasiRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'anak_id',
        'vaksin_code',
        'dosis',
        'given_at',
        'keterangan',
        'posyandu_id',
        'created_by',
        'verified_by',
        'verified_at',
        'reject_reason',
    ];

    protected $casts = [
        'given_at' => 'date',
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
     * Get nama vaksin yang lebih readable
     */
    public function getVaksinNamaAttribute()
    {
        $names = [
            'BCG' => 'BCG',
            'HB0' => 'Hepatitis B-0',
            'DPT1' => 'DPT-HB-Hib 1',
            'DPT2' => 'DPT-HB-Hib 2',
            'DPT3' => 'DPT-HB-Hib 3',
            'POLIO1' => 'Polio 1',
            'POLIO2' => 'Polio 2',
            'POLIO3' => 'Polio 3',
            'POLIO4' => 'Polio 4',
            'CAMPAK' => 'Campak',
        ];

        return $names[$this->vaksin_code] ?? $this->vaksin_code;
    }
}
