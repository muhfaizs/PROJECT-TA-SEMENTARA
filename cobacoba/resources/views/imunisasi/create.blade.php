@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Input Imunisasi</h2>
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
    @if($anak->imunisasi->count() > 0)
      <div style="margin-top:8px;padding-top:8px;border-top:1px solid #e5e7eb">
        <strong>Riwayat Imunisasi:</strong>
        @foreach($anak->imunisasi->take(5) as $i)
          <span class="badge badge-success" style="margin:2px">{{ $i->vaksin_code }}</span>
        @endforeach
      </div>
    @endif
  </div>

  <form method="POST" action="{{ route('imunisasi.store', $anak->id) }}">
    @csrf
    
    <div class="row">
      <div class="col">
        <label for="vaksin_code">Jenis Vaksin <span style="color:red">*</span></label>
        <select id="vaksin_code" name="vaksin_code" required>
          <option value="">- Pilih Vaksin -</option>
          @foreach($vaksins as $code => $nama)
            <option value="{{ $code }}" {{ old('vaksin_code') == $code ? 'selected' : '' }}>
              {{ $nama }}
            </option>
          @endforeach
        </select>
        @error('vaksin_code')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <div class="col">
        <label for="dosis">Dosis</label>
        <input type="text" id="dosis" name="dosis" value="{{ old('dosis') }}" placeholder="Contoh: Ke-1">
        @error('dosis')<div class="error-msg">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="row">
      <div class="col">
        <label for="given_at">Tanggal Pemberian <span style="color:red">*</span></label>
        <input type="date" id="given_at" name="given_at" value="{{ old('given_at', now()->format('Y-m-d')) }}" required>
        @error('given_at')<div class="error-msg">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="row">
      <div class="col-full">
        <label for="keterangan">Keterangan</label>
        <textarea id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
        @error('keterangan')<div class="error-msg">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="mt-2">
      <button type="submit">💾 Simpan Imunisasi</button>
      <a href="{{ route('anak.show', $anak->id) }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
