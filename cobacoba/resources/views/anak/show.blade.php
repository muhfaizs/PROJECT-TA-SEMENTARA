@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Detail Anak</h2>
  <a href="{{ route('anak.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card">
  <div class="row">
    <div class="col">
      <h3 style="margin-bottom:16px">Informasi Anak</h3>
      <table style="border:none">
        <tr>
          <td style="border:none;padding:8px 0;width:150px"><strong>Nama</strong></td>
          <td style="border:none;padding:8px 0">: {{ $anak->nama }}</td>
        </tr>
        <tr>
          <td style="border:none;padding:8px 0"><strong>NIK</strong></td>
          <td style="border:none;padding:8px 0">: {{ $anak->masked_nik }}</td>
        </tr>
        <tr>
          <td style="border:none;padding:8px 0"><strong>Tanggal Lahir</strong></td>
          <td style="border:none;padding:8px 0">: {{ $anak->tgl_lahir->format('d/m/Y') }}</td>
        </tr>
        <tr>
          <td style="border:none;padding:8px 0"><strong>Usia</strong></td>
          <td style="border:none;padding:8px 0">: {{ $anak->usia_tahun }} tahun {{ $anak->usia_bulan % 12 }} bulan</td>
        </tr>
        <tr>
          <td style="border:none;padding:8px 0"><strong>Jenis Kelamin</strong></td>
          <td style="border:none;padding:8px 0">: {{ $anak->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        @if($anak->bb_lahir)
        <tr>
          <td style="border:none;padding:8px 0"><strong>BB Lahir</strong></td>
          <td style="border:none;padding:8px 0">: {{ $anak->bb_lahir }} kg</td>
        </tr>
        @endif
        @if($anak->tb_lahir)
        <tr>
          <td style="border:none;padding:8px 0"><strong>PB Lahir</strong></td>
          <td style="border:none;padding:8px 0">: {{ $anak->tb_lahir }} cm</td>
        </tr>
        @endif
      </table>
    </div>

    <div class="col">
      <h3 style="margin-bottom:16px">Informasi Ibu</h3>
      <table style="border:none">
        <tr>
          <td style="border:none;padding:8px 0;width:150px"><strong>Nama Ibu</strong></td>
          <td style="border:none;padding:8px 0">: 
            <a href="{{ route('ibu.show', $anak->ibu->id) }}" style="color:var(--pri)">{{ $anak->ibu->nama }}</a>
          </td>
        </tr>
        <tr>
          <td style="border:none;padding:8px 0"><strong>Posyandu</strong></td>
          <td style="border:none;padding:8px 0">: {{ $anak->ibu->posyandu->nama }}</td>
        </tr>
      </table>

      <div style="margin-top:20px">
        <a href="{{ route('tumbuh.create', $anak->id) }}" class="btn" style="background:#10b981">📏 Input Pengukuran</a>
        <a href="{{ route('imunisasi.create', $anak->id) }}" class="btn" style="background:#f59e0b">💉 Input Imunisasi</a>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <h3 style="margin-bottom:16px">Riwayat Pengukuran (10 Terakhir)</h3>
  @if($anak->tumbuh->count() > 0)
    <table>
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>BB (kg)</th>
          <th>TB (cm)</th>
          <th>LL (cm)</th>
          <th>Status Gizi</th>
          <th>Verifikasi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($anak->tumbuh as $t)
          <tr>
            <td>{{ $t->measured_at->format('d/m/Y') }}</td>
            <td>{{ $t->bb_kg }}</td>
            <td>{{ $t->tb_cm }}</td>
            <td>{{ $t->ll_cm ?? '-' }}</td>
            <td><span class="badge badge-{{ $t->status_badge }}">{{ strtoupper($t->status_gizi) }}</span></td>
            <td>
              @if($t->is_verified)
                <span class="badge badge-success">✓ Terverifikasi</span>
              @else
                <span class="badge badge-warning">⏳ Menunggu</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="muted text-center" style="padding:20px 0">Belum ada data pengukuran</p>
  @endif
</div>

<div class="card">
  <h3 style="margin-bottom:16px">Riwayat Imunisasi (10 Terakhir)</h3>
  @if($anak->imunisasi->count() > 0)
    <table>
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Vaksin</th>
          <th>Dosis</th>
          <th>Keterangan</th>
          <th>Verifikasi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($anak->imunisasi as $i)
          <tr>
            <td>{{ $i->given_at->format('d/m/Y') }}</td>
            <td><strong>{{ $i->vaksin_nama }}</strong></td>
            <td>{{ $i->dosis ?? '-' }}</td>
            <td class="muted">{{ $i->keterangan ?? '-' }}</td>
            <td>
              @if($i->is_verified)
                <span class="badge badge-success">✓ Terverifikasi</span>
              @else
                <span class="badge badge-warning">⏳ Menunggu</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="muted text-center" style="padding:20px 0">Belum ada data imunisasi</p>
  @endif
</div>
@endsection
