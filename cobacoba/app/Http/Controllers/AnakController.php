<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Ibu;
use App\Http\Requests\StoreAnakRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Anak::with(['ibu.posyandu', 'latestTumbuh']);

        // Filter untuk kader hanya lihat posyandunya sendiri
        if (Auth::user()->role === 'kader') {
            $query->whereHas('ibu', function($q) {
                $q->where('posyandu_id', Auth::user()->posyandu_id);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhereHas('ibu', fn($qq) => $qq->where('nama', 'like', "%{$search}%"));
            });
        }

        $list = $query->latest()->paginate(15);

        return view('anak.index', [
            'title' => 'Data Anak',
            'list' => $list,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ibus = Ibu::orderBy('nama')->get();

        // Pre-select ibu jika ada parameter
        $selectedIbu = null;
        if ($request->filled('ibu_id')) {
            $selectedIbu = Ibu::find($request->ibu_id);
        }

        return view('anak.create', [
            'title' => 'Registrasi Anak',
            'ibus' => $ibus,
            'selectedIbu' => $selectedIbu,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnakRequest $request)
    {
        $anak = Anak::create($request->validated());

        return redirect()->route('anak.show', $anak->id)->with('success', 'Data anak berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anak $anak)
    {
        $anak->load([
            'ibu.posyandu',
            'tumbuh' => fn($q) => $q->latest('measured_at')->take(10),
            'imunisasi' => fn($q) => $q->latest('given_at')->take(10),
        ]);

        return view('anak.show', [
            'title' => 'Detail Anak',
            'anak' => $anak,
        ]);
    }
}
