@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Detail Ibu</h2>
  <a href="{{ route('ibu.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card">
  <div class="row">
    <div class="col">
      <h3 style="margin-bottom:16px">Informasi Ibu</h3>
      <table style="border:none">
        <tr>
          <td style="border:none;padding:8px 0;width:150px"><strong>NIK</strong></td>
          <td style="border:none;padding:8px 0">: {{ $ibu->masked_nik }}</td>
        </tr>
        <tr>
          <td style="border:none;padding:8px 0"><strong>Nama</strong></td>
          <td style="border:none;padding:8px 0">: {{ $ibu->nama }}</td>
        </tr>
        <tr>
          <td style="border:none;padding:8px 0"><strong>Tanggal Lahir</strong></td>
          <td style="border:none;padding:8px 0">: {{ $ibu->tgl_lahir->format('d/m/Y') }} ({{ $ibu->usia }} tahun)</td>
        </tr>
        <tr>
          <td style="border:none;padding:8px 0"><strong>No. HP</strong></td>
          <td style="border:none;padding:8px 0">: {{ $ibu->hp ?? '-' }}</td>
        </tr>
        <tr>
          <td style="border:none;padding:8px 0;vertical-align:top"><strong>Alamat</strong></td>
          <td style="border:none;padding:8px 0">: {{ $ibu->alamat ?? '-' }}</td>
        </tr>
        <tr>
          <td style="border:none;padding:8px 0"><strong>Posyandu</strong></td>
          <td style="border:none;padding:8px 0">: {{ $ibu->posyandu->nama }}</td>
        </tr>
      </table>
    </div>

    <div class="col">
      <h3 style="margin-bottom:16px">Status Kehamilan</h3>
      @if($ibu->hpht)
        <table style="border:none">
          <tr>
            <td style="border:none;padding:8px 0;width:150px"><strong>HPHT</strong></td>
            <td style="border:none;padding:8px 0">: {{ $ibu->hpht->format('d/m/Y') }}</td>
          </tr>
          <tr>
            <td style="border:none;padding:8px 0"><strong>Usia Kehamilan</strong></td>
            <td style="border:none;padding:8px 0">: {{ $ibu->usia_kehamilan }} minggu</td>
          </tr>
          <tr>
            <td style="border:none;padding:8px 0"><strong>Taksiran Persalinan</strong></td>
            <td style="border:none;padding:8px 0">: {{ $ibu->tp?->format('d/m/Y') ?? '-' }}</td>
          </tr>
          <tr>
            <td style="border:none;padding:8px 0"><strong>Skor Risiko</strong></td>
            <td style="border:none;padding:8px 0">: 
              @if($ibu->risk_score > 5)
                <span class="badge badge-danger">{{ $ibu->risk_score }} (Tinggi)</span>
              @else
                <span class="badge badge-success">{{ $ibu->risk_score ?? 0 }} (Normal)</span>
              @endif
            </td>
          </tr>
        </table>
      @else
        <p class="muted">Tidak sedang hamil</p>
      @endif
    </div>
  </div>

  <div style="margin-top:16px;padding-top:16px;border-top:1px solid #e5e7eb">
    <small class="muted">Didaftarkan oleh: {{ $ibu->creator->name }} pada {{ $ibu->created_at->format('d/m/Y H:i') }}</small>
  </div>
</div>

<div class="card">
  <div class="flex justify-between items-center" style="margin-bottom:16px">
    <h3 style="margin:0">Daftar Anak</h3>
    <a href="{{ route('anak.create', ['ibu_id' => $ibu->id]) }}" class="btn btn-sm">➕ Tambah Anak</a>
  </div>

  @if($ibu->anaks->count() > 0)
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Tgl Lahir</th>
          <th>Usia</th>
          <th>JK</th>
          <th>Status Terakhir</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($ibu->anaks as $anak)
          <tr>
            <td><strong>{{ $anak->nama }}</strong></td>
            <td>{{ $anak->tgl_lahir->format('d/m/Y') }}</td>
            <td>{{ $anak->usia_bulan }} bulan</td>
            <td>{{ $anak->jk }}</td>
            <td>
              @if($anak->latestTumbuh)
                <span class="badge badge-{{ $anak->latestTumbuh->status_badge }}">
                  {{ strtoupper($anak->latestTumbuh->status_gizi) }}
                </span>
                <div class="muted">{{ $anak->latestTumbuh->measured_at->format('d/m/Y') }}</div>
              @else
                <span class="badge badge-muted">Belum ada data</span>
              @endif
            </td>
            <td>
              <a href="{{ route('anak.show', $anak->id) }}" class="btn btn-sm">Detail</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="muted text-center" style="padding:20px 0">Belum ada data anak</p>
  @endif
</div>
@endsection
