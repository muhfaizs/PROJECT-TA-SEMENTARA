<?php

namespace App\Http\Controllers;

use App\Models\Ibu;
use App\Models\Posyandu;
use App\Http\Requests\StoreIbuRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IbuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ibu::with('posyandu');

        // Filter untuk kader hanya lihat posyandunya sendiri
        if (Auth::user()->role === 'kader') {
            $query->where('posyandu_id', Auth::user()->posyandu_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter posyandu
        if ($request->filled('posyandu_id')) {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        $list = $query->latest()->paginate(15);

        return view('ibu.index', [
            'title' => 'Data Ibu',
            'list' => $list,
            'posyandus' => Posyandu::orderBy('nama')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posyandus = Posyandu::orderBy('nama')->get();

        return view('ibu.create', [
            'title' => 'Registrasi Ibu',
            'posyandus' => $posyandus,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIbuRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        // Hitung Taksiran Persalinan (TP) jika HPHT diisi
        if (!empty($data['hpht'])) {
            $data['tp'] = Carbon::parse($data['hpht'])->addDays(280);
            
            // Simple risk score calculation (usia ibu)
            $usia = Carbon::parse($data['tgl_lahir'])->age;
            $riskScore = 0;
            if ($usia < 18 || $usia > 35) $riskScore += 3;
            $data['risk_score'] = $riskScore;
        }

        $ibu = Ibu::create($data);

        return redirect()->route('ibu.show', $ibu->id)->with('success', 'Data ibu berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ibu $ibu)
    {
        $ibu->load(['posyandu', 'anaks.latestTumbuh', 'creator']);

        return view('ibu.show', [
            'title' => 'Detail Ibu',
            'ibu' => $ibu,
        ]);
    }
}
