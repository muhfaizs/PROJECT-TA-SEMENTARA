<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'desa',
        'puskesmas',
    ];

    /**
     * Get users yang terdaftar di posyandu ini
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get ibu-ibu yang terdaftar di posyandu ini
     */
    public function ibus()
    {
        return $this->hasMany(Ibu::class);
    }

    /**
     * Get tumbuh records dari posyandu ini
     */
    public function tumbuhRecords()
    {
        return $this->hasMany(TumbuhRecord::class);
    }

    /**
     * Get imunisasi records dari posyandu ini
     */
    public function imunisasiRecords()
    {
        return $this->hasMany(ImunisasiRecord::class);
    }
}
