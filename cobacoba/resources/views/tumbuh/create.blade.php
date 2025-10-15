@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Input Pengukuran</h2>
  <a href="{{ route('anak.show', $anak->id) }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card">
  <div style="background:#f8fafc;padding:12px;border-radius:8px;margin-bottom:20px">
    <div style="font-size:1.1rem;font-weight:600;margin-bottom:4px">{{ $anak->nama }}</div>
    <div class="muted">
      {{ $anak->jk == 'L' ? 'Laki-laki' : 'Perempuan' }} • 
      Usia: {{ $anak->usia_tahun }} tahun {{ $anak->usia_bulan % 12 }} bulan •
      Ibu: {{ $anak->ibu->nama }}
    </div>
    @if($anak->latestTumbuh)
      <div style="margin-top:8px;padding-top:8px;border-top:1px solid #e5e7eb">
        <strong>Pengukuran Terakhir:</strong> 
        {{ $anak->latestTumbuh->measured_at->format('d/m/Y') }} -
        BB: {{ $anak->latestTumbuh->bb_kg }} kg, TB: {{ $anak->latestTumbuh->tb_cm }} cm -
        <span class="badge badge-{{ $anak->latestTumbuh->status_badge }}">{{ strtoupper($anak->latestTumbuh->status_gizi) }}</span>
      </div>
    @endif
  </div>

  <form method="POST" action="{{ route('tumbuh.store', $anak->id) }}">
    @csrf
    
    <div class="row">
      <div class="col">
        <label for="measured_at">Tanggal Pengukuran <span style="color:red">*</span></label>
        <input type="date" id="measured_at" name="measured_at" value="{{ old('measured_at', now()->format('Y-m-d')) }}" required>
        @error('measured_at')<div class="error-msg">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="row">
      <div class="col">
        <label for="bb_kg">Berat Badan (kg) <span style="color:red">*</span></label>
        <input type="number" id="bb_kg" name="bb_kg" value="{{ old('bb_kg') }}" step="0.01" min="1" max="150" required>
        @error('bb_kg')<div class="error-msg">{{ $message }}</div>@enderror
        <div class="muted">Contoh: 12.5</div>
      </div>

      <div class="col">
        <label for="tb_cm">Tinggi Badan (cm) <span style="color:red">*</span></label>
        <input type="number" id="tb_cm" name="tb_cm" value="{{ old('tb_cm') }}" step="0.1" min="30" max="200" required>
        @error('tb_cm')<div class="error-msg">{{ $message }}</div>@enderror
        <div class="muted">Contoh: 95.5</div>
      </div>

      <div class="col">
        <label for="ll_cm">Lingkar Lengan (cm)</label>
        <input type="number" id="ll_cm" name="ll_cm" value="{{ old('ll_cm') }}" step="0.1" min="5" max="50">
        @error('ll_cm')<div class="error-msg">{{ $message }}</div>@enderror
        <div class="muted">Opsional</div>
      </div>
    </div>

    <div class="mt-2">
      <button type="submit">💾 Simpan Pengukuran</button>
      <a href="{{ route('anak.show', $anak->id) }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
