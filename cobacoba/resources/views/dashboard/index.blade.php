@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Dashboard</h2>
  <div class="muted">
    {{ auth()->user()->name }} - 
    <strong>{{ ucfirst(auth()->user()->role) }}</strong>
    @if(auth()->user()->posyandu)
      ({{ auth()->user()->posyandu->nama }})
    @endif
  </div>
</div>

<div class="stats">
  <div class="stat-card">
    <h3>Total Ibu</h3>
    <div class="value">{{ $stats['total_ibu'] }}</div>
  </div>
  <div class="stat-card">
    <h3>Total Anak</h3>
    <div class="value">{{ $stats['total_anak'] }}</div>
  </div>
  <div class="stat-card">
    <h3>Pengukuran Bulan Ini</h3>
    <div class="value">{{ $stats['tumbuh_bulan_ini'] }}</div>
  </div>
  <div class="stat-card">
    <h3>Imunisasi Bulan Ini</h3>
    <div class="value">{{ $stats['imunisasi_bulan_ini'] }}</div>
  </div>
</div>

@if(isset($stats['pending_verifikasi']))
<div class="card">
  <h3 style="margin-bottom:12px">⏳ Menunggu Verifikasi</h3>
  <p style="font-size:1.5rem;font-weight:700;color:var(--pri)">{{ $stats['pending_verifikasi'] }} data</p>
  <a href="{{ route('verifikasi.index') }}" class="btn btn-sm">Lihat Detail</a>
</div>
@endif

<div class="row">
  <div class="col">
    <div class="card">
      <h3 style="margin-bottom:12px">⚠️ Ibu Hamil Risiko Tinggi</h3>
      @if($ibu_risiko->count() > 0)
        <table>
          <thead>
            <tr>
              <th>Nama</th>
              <th>Usia Kehamilan</th>
              <th>Skor Risiko</th>
            </tr>
          </thead>
          <tbody>
            @foreach($ibu_risiko as $ibu)
              <tr>
                <td>
                  <a href="{{ route('ibu.show', $ibu->id) }}" style="color:var(--pri);font-weight:600">
                    {{ $ibu->nama }}
                  </a>
                  <div class="muted">{{ $ibu->posyandu->nama }}</div>
                </td>
                <td>{{ $ibu->usia_kehamilan }} minggu</td>
                <td><span class="badge badge-danger">{{ $ibu->risk_score }}</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <p class="muted">Tidak ada data ibu hamil risiko tinggi</p>
      @endif
    </div>
  </div>

  <div class="col">
    <div class="card">
      <h3 style="margin-bottom:12px">⚠️ Anak dengan Status Gizi Non-Normal</h3>
      @if($anak_gizi->count() > 0)
        <table>
          <thead>
            <tr>
              <th>Nama Anak</th>
              <th>Tanggal</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($anak_gizi as $record)
              <tr>
                <td>
                  <a href="{{ route('anak.show', $record->anak->id) }}" style="color:var(--pri);font-weight:600">
                    {{ $record->anak->nama }}
                  </a>
                  <div class="muted">{{ $record->anak->ibu->nama }}</div>
                </td>
                <td>{{ $record->measured_at->format('d/m/Y') }}</td>
                <td>
                  <span class="badge badge-{{ $record->status_badge }}">
                    {{ strtoupper($record->status_gizi) }}
                  </span>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <p class="muted">Tidak ada data anak dengan status gizi non-normal</p>
      @endif
    </div>
  </div>
</div>

<div class="card">
  <h3 style="margin-bottom:12px">📊 Quick Actions</h3>
  <div style="display:flex;gap:12px;flex-wrap:wrap">
    <a href="{{ route('ibu.create') }}" class="btn">➕ Registrasi Ibu</a>
    <a href="{{ route('anak.create') }}" class="btn">➕ Registrasi Anak</a>
    <a href="{{ route('ibu.index') }}" class="btn btn-secondary">📋 Lihat Data Ibu</a>
    <a href="{{ route('anak.index') }}" class="btn btn-secondary">📋 Lihat Data Anak</a>
  </div>
</div>
@endsection
