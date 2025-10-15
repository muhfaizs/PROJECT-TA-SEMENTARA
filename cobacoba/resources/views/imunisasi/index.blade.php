@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Data Imunisasi</h2>
  <div></div>
</div>

<div class="card">
  <form method="GET" class="search-box">
    <select name="vaksin" style="width:auto">
      <option value="">Semua Vaksin</option>
      <option value="BCG" {{ request('vaksin') == 'BCG' ? 'selected' : '' }}>BCG</option>
      <option value="HB0" {{ request('vaksin') == 'HB0' ? 'selected' : '' }}>Hepatitis B-0</option>
      <option value="DPT1" {{ request('vaksin') == 'DPT1' ? 'selected' : '' }}>DPT-HB-Hib 1</option>
      <option value="DPT2" {{ request('vaksin') == 'DPT2' ? 'selected' : '' }}>DPT-HB-Hib 2</option>
      <option value="DPT3" {{ request('vaksin') == 'DPT3' ? 'selected' : '' }}>DPT-HB-Hib 3</option>
      <option value="POLIO1" {{ request('vaksin') == 'POLIO1' ? 'selected' : '' }}>Polio 1</option>
      <option value="CAMPAK" {{ request('vaksin') == 'CAMPAK' ? 'selected' : '' }}>Campak</option>
    </select>
    <button type="submit">🔍 Filter</button>
    @if(request('vaksin'))
      <a href="{{ route('imunisasi.index') }}" class="btn btn-secondary">Reset</a>
    @endif
  </form>

  @if($list->count() > 0)
    <table>
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Nama Anak</th>
          <th>Usia</th>
          <th>Vaksin</th>
          <th>Dosis</th>
          <th>Posyandu</th>
          <th>Verifikasi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($list as $record)
          <tr>
            <td>{{ $record->given_at->format('d/m/Y') }}</td>
            <td>
              <a href="{{ route('anak.show', $record->anak->id) }}" style="color:var(--pri);font-weight:600">
                {{ $record->anak->nama }}
              </a>
              <div class="muted">Ibu: {{ $record->anak->ibu->nama }}</div>
            </td>
            <td>{{ $record->anak->usia_bulan }} bln</td>
            <td><strong>{{ $record->vaksin_nama }}</strong></td>
            <td>{{ $record->dosis ?? '-' }}</td>
            <td>{{ $record->posyandu->nama }}</td>
            <td>
              @if($record->is_verified)
                <span class="badge badge-success">✓</span>
              @else
                <span class="badge badge-warning">⏳</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="pagination">
      {!! $list->links() !!}
    </div>
  @else
    <p class="muted text-center" style="padding:40px 0">Tidak ada data ditemukan</p>
  @endif
</div>
@endsection
