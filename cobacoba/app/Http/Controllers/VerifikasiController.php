<?php

namespace App\Http\Controllers;

use App\Models\TumbuhRecord;
use App\Models\ImunisasiRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
    /**
     * Display verification queue
     */
    public function index(Request $request)
    {
        // Gabungkan data tumbuh & imunisasi yang belum diverifikasi
        $tumbuhRecords = TumbuhRecord::with(['anak.ibu', 'posyandu', 'creator'])
            ->whereNull('verified_at')
            ->get()
            ->map(function($record) {
                return [
                    'id' => $record->id,
                    'type' => 'tumbuh',
                    'type_label' => 'Pengukuran',
                    'nama' => $record->anak->nama,
                    'nama_ibu' => $record->anak->ibu->nama,
                    'tanggal' => $record->measured_at->format('d/m/Y'),
                    'ringkas' => "BB: {$record->bb_kg} kg, TB: {$record->tb_cm} cm, Status: {$record->status_gizi}",
                    'posyandu' => $record->posyandu->nama,
                    'created_by' => $record->creator->name,
                    'created_at' => $record->created_at,
                    'record' => $record,
                ];
            });

        $imunisasiRecords = ImunisasiRecord::with(['anak.ibu', 'posyandu', 'creator'])
            ->whereNull('verified_at')
            ->get()
            ->map(function($record) {
                return [
                    'id' => $record->id,
                    'type' => 'imunisasi',
                    'type_label' => 'Imunisasi',
                    'nama' => $record->anak->nama,
                    'nama_ibu' => $record->anak->ibu->nama,
                    'tanggal' => $record->given_at->format('d/m/Y'),
                    'ringkas' => "{$record->vaksin_nama}" . ($record->dosis ? " - {$record->dosis}" : ''),
                    'posyandu' => $record->posyandu->nama,
                    'created_by' => $record->creator->name,
                    'created_at' => $record->created_at,
                    'record' => $record,
                ];
            });

        // Gabungkan dan sort by created_at
        $items = $tumbuhRecords->concat($imunisasiRecords)->sortByDesc('created_at')->values();

        // Filter by type
        if ($request->filled('type')) {
            $items = $items->where('type', $request->type)->values();
        }

        return view('verifikasi.index', [
            'title' => 'Verifikasi Data',
            'items' => $items,
        ]);
    }

    /**
     * Approve record
     */
    public function approve(Request $request, $id)
    {
        $type = $request->input('type');
        
        if ($type === 'tumbuh') {
            $record = TumbuhRecord::findOrFail($id);
        } else {
            $record = ImunisasiRecord::findOrFail($id);
        }

        $record->update([
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Data berhasil diverifikasi');
    }

    /**
     * Reject record
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'nullable|string|max:500',
        ]);

        $type = $request->input('type');
        
        if ($type === 'tumbuh') {
            $record = TumbuhRecord::findOrFail($id);
        } else {
            $record = ImunisasiRecord::findOrFail($id);
        }

        $record->update([
            'reject_reason' => $request->reject_reason ?? 'Data tidak valid',
            'verified_by' => Auth::id(),
            'verified_at' => now(), // Tetap set verified_at tapi ada reject_reason
        ]);

        return back()->with('success', 'Data ditolak dengan alasan: ' . $record->reject_reason);
    }
}
