<?php

namespace App\Http\Controllers;

use App\Models\Ibu;
use App\Models\Anak;
use App\Models\TumbuhRecord;
use App\Models\ImunisasiRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // Data umum untuk semua role
        $data = [
            'title' => 'Dashboard',
            'user' => $user,
        ];

        // Filter berdasarkan posyandu untuk kader
        $posyanduFilter = $role === 'kader' ? $user->posyandu_id : null;

        // Hitung statistik
        $data['stats'] = [
            'total_ibu' => Ibu::when($posyanduFilter, fn($q) => $q->where('posyandu_id', $posyanduFilter))->count(),
            'total_anak' => Anak::when($posyanduFilter, function($q) use ($posyanduFilter) {
                $q->whereHas('ibu', fn($qq) => $qq->where('posyandu_id', $posyanduFilter));
            })->count(),
            'tumbuh_bulan_ini' => TumbuhRecord::when($posyanduFilter, fn($q) => $q->where('posyandu_id', $posyanduFilter))
                ->whereMonth('measured_at', now()->month)
                ->whereYear('measured_at', now()->year)
                ->count(),
            'imunisasi_bulan_ini' => ImunisasiRecord::when($posyanduFilter, fn($q) => $q->where('posyandu_id', $posyanduFilter))
                ->whereMonth('given_at', now()->month)
                ->whereYear('given_at', now()->year)
                ->count(),
        ];

        // Data khusus untuk bidan/dokter/admin (verifikasi)
        if (in_array($role, ['bidan', 'dokter', 'admin'])) {
            $data['stats']['pending_verifikasi'] = TumbuhRecord::whereNull('verified_at')->count() 
                + ImunisasiRecord::whereNull('verified_at')->count();
        }

        // Data ibu hamil risiko tinggi
        $data['ibu_risiko'] = Ibu::when($posyanduFilter, fn($q) => $q->where('posyandu_id', $posyanduFilter))
            ->whereNotNull('hpht')
            ->where('risk_score', '>', 5)
            ->with('posyandu')
            ->latest()
            ->take(5)
            ->get();

        // Data anak dengan status gizi non-normal
        $data['anak_gizi'] = TumbuhRecord::with(['anak.ibu', 'posyandu'])
            ->when($posyanduFilter, fn($q) => $q->where('posyandu_id', $posyanduFilter))
            ->whereIn('status_gizi', ['stunted', 'wasted', 'overweight'])
            ->whereNotNull('verified_at')
            ->latest('measured_at')
            ->take(5)
            ->get();

        return view('dashboard.index', $data);
    }
}
