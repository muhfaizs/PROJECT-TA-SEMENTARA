<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Anak extends Model
{
    use HasFactory;

    protected $fillable = [
        'ibu_id',
        'nik',
        'nama',
        'tgl_lahir',
        'jk',
        'bb_lahir',
        'tb_lahir',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'bb_lahir' => 'decimal:2',
        'tb_lahir' => 'decimal:2',
    ];

    /**
     * Get ibu
     */
    public function ibu()
    {
        return $this->belongsTo(Ibu::class);
    }

    /**
     * Get tumbuh records
     */
    public function tumbuh()
    {
        return $this->hasMany(TumbuhRecord::class);
    }

    /**
     * Get imunisasi records
     */
    public function imunisasi()
    {
        return $this->hasMany(ImunisasiRecord::class);
    }

    /**
     * Get latest tumbuh record
     */
    public function latestTumbuh()
    {
        return $this->hasOne(TumbuhRecord::class)->latestOfMany('measured_at');
    }

    /**
     * Hitung usia dalam bulan
     */
    public function getUsiaBulanAttribute()
    {
        return Carbon::parse($this->tgl_lahir)->diffInMonths(now());
    }

    /**
     * Hitung usia dalam tahun
     */
    public function getUsiaTahunAttribute()
    {
        return Carbon::parse($this->tgl_lahir)->age;
    }

    /**
     * Mask NIK untuk keamanan
     */
    public function getMaskedNikAttribute()
    {
        if (!$this->nik) return '-';
        return str_repeat('*', 12) . substr($this->nik, -4);
    }
}
