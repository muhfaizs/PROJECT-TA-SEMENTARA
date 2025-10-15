<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\TumbuhRecord;
use App\Http\Requests\StoreTumbuhRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TumbuhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TumbuhRecord::with(['anak.ibu', 'posyandu']);

        // Filter untuk kader hanya lihat posyandunya sendiri
        if (Auth::user()->role === 'kader') {
            $query->where('posyandu_id', Auth::user()->posyandu_id);
        }

        // Filter bulan
        if ($request->filled('bulan')) {
            $date = Carbon::parse($request->bulan . '-01');
            $query->whereMonth('measured_at', $date->month)
                  ->whereYear('measured_at', $date->year);
        }

        // Filter status gizi
        if ($request->filled('status_gizi')) {
            $query->where('status_gizi', $request->status_gizi);
        }

        $list = $query->latest('measured_at')->paginate(15);

        return view('tumbuh.index', [
            'title' => 'Data Tumbuh Kembang',
            'list' => $list,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Anak $anak)
    {
        $anak->load('ibu.posyandu', 'latestTumbuh');

        return view('tumbuh.create', [
            'title' => 'Input Pengukuran',
            'anak' => $anak,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTumbuhRequest $request, Anak $anak)
    {
        $data = $request->validated();
        $data['anak_id'] = $anak->id;
        $data['status_gizi'] = $this->hitungStatusGizi($anak, $data['bb_kg'], $data['tb_cm'], $data['measured_at']);
        $data['posyandu_id'] = Auth::user()->posyandu_id ?? $anak->ibu->posyandu_id;
        $data['created_by'] = Auth::id();

        TumbuhRecord::create($data);

        return redirect()->route('anak.show', $anak->id)->with('success', 'Data pengukuran berhasil disimpan');
    }

    /**
     * Hitung status gizi (simplified version - bisa dikembangkan dengan z-score WHO)
     */
    private function hitungStatusGizi(Anak $anak, $bb, $tb, $tgl)
    {
        // Placeholder: implementasi sederhana
        // Untuk produksi, gunakan z-score WHO standards
        
        $usiaBulan = Carbon::parse($anak->tgl_lahir)->diffInMonths(Carbon::parse($tgl));
        
        // Simplified BB/U ratio
        $bbIdeal = 3 + ($usiaBulan * 0.5); // Sangat disederhanakan
        $ratio = $bb / $bbIdeal;

        if ($ratio < 0.7) return 'wasted';
        if ($ratio > 1.3) return 'overweight';
        
        // Check stunting (TB/U)
        $tbIdeal = 50 + ($usiaBulan * 1.5); // Sangat disederhanakan
        if ($tb < ($tbIdeal * 0.85)) return 'stunted';

        return 'normal';
    }
}
