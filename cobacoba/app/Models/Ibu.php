<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ibu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama',
        'tgl_lahir',
        'hp',
        'alamat',
        'posyandu_id',
        'hpht',
        'tp',
        'risk_score',
        'created_by',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'hpht' => 'date',
        'tp' => 'date',
        'verified_at' => 'datetime',
    ];

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
     * Get anak-anak dari ibu ini
     */
    public function anaks()
    {
        return $this->hasMany(Anak::class);
    }

    /**
     * Hitung usia dalam tahun
     */
    public function getUsiaAttribute()
    {
        return Carbon::parse($this->tgl_lahir)->age;
    }

    /**
     * Hitung usia kehamilan dalam minggu (jika HPHT diisi)
     */
    public function getUsiaKehamilanAttribute()
    {
        if (!$this->hpht) return null;
        return Carbon::parse($this->hpht)->diffInWeeks(now());
    }

    /**
     * Mask NIK untuk keamanan (tampilkan 4 digit terakhir)
     */
    public function getMaskedNikAttribute()
    {
        return str_repeat('*', 12) . substr($this->nik, -4);
    }
}
