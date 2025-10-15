<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\ImunisasiRecord;
use App\Http\Requests\StoreImunisasiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImunisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ImunisasiRecord::with(['anak.ibu', 'posyandu']);

        // Filter untuk kader hanya lihat posyandunya sendiri
        if (Auth::user()->role === 'kader') {
            $query->where('posyandu_id', Auth::user()->posyandu_id);
        }

        // Filter vaksin
        if ($request->filled('vaksin')) {
            $query->where('vaksin_code', $request->vaksin);
        }

        $list = $query->latest('given_at')->paginate(15);

        return view('imunisasi.index', [
            'title' => 'Data Imunisasi',
            'list' => $list,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Anak $anak)
    {
        $anak->load('ibu.posyandu', 'imunisasi');

        // Daftar vaksin standar
        $vaksins = [
            'HB0' => 'Hepatitis B-0 (0-7 hari)',
            'BCG' => 'BCG (1 bulan)',
            'DPT1' => 'DPT-HB-Hib 1 (2 bulan)',
            'POLIO1' => 'Polio 1 (2 bulan)',
            'DPT2' => 'DPT-HB-Hib 2 (3 bulan)',
            'POLIO2' => 'Polio 2 (3 bulan)',
            'DPT3' => 'DPT-HB-Hib 3 (4 bulan)',
            'POLIO3' => 'Polio 3 (4 bulan)',
            'IPV' => 'IPV (4 bulan)',
            'CAMPAK' => 'Campak/MR (9 bulan)',
        ];

        return view('imunisasi.create', [
            'title' => 'Input Imunisasi',
            'anak' => $anak,
            'vaksins' => $vaksins,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreImunisasiRequest $request, Anak $anak)
    {
        $data = $request->validated();
        $data['anak_id'] = $anak->id;
        $data['posyandu_id'] = Auth::user()->posyandu_id ?? $anak->ibu->posyandu_id;
        $data['created_by'] = Auth::id();

        ImunisasiRecord::create($data);

        return redirect()->route('anak.show', $anak->id)->with('success', 'Data imunisasi berhasil disimpan');
    }
}
