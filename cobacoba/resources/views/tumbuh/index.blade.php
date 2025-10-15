@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Data Tumbuh Kembang</h2>
  <div></div>
</div>

<div class="card">
  <form method="GET" class="search-box">
    <input type="month" name="bulan" value="{{ request('bulan', now()->format('Y-m')) }}">
    <select name="status_gizi" style="width:auto">
      <option value="">Semua Status</option>
      <option value="normal" {{ request('status_gizi') == 'normal' ? 'selected' : '' }}>Normal</option>
      <option value="stunted" {{ request('status_gizi') == 'stunted' ? 'selected' : '' }}>Stunted</option>
      <option value="wasted" {{ request('status_gizi') == 'wasted' ? 'selected' : '' }}>Wasted</option>
      <option value="overweight" {{ request('status_gizi') == 'overweight' ? 'selected' : '' }}>Overweight</option>
    </select>
    <button type="submit">🔍 Filter</button>
    @if(request()->hasAny(['bulan', 'status_gizi']))
      <a href="{{ route('tumbuh.index') }}" class="btn btn-secondary">Reset</a>
    @endif
  </form>

  @if($list->count() > 0)
    <table>
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Nama Anak</th>
          <th>Usia</th>
          <th>BB (kg)</th>
          <th>TB (cm)</th>
          <th>LL (cm)</th>
          <th>Status Gizi</th>
          <th>Posyandu</th>
          <th>Verifikasi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($list as $record)
          <tr>
            <td>{{ $record->measured_at->format('d/m/Y') }}</td>
            <td>
              <a href="{{ route('anak.show', $record->anak->id) }}" style="color:var(--pri);font-weight:600">
                {{ $record->anak->nama }}
              </a>
              <div class="muted">Ibu: {{ $record->anak->ibu->nama }}</div>
            </td>
            <td>{{ $record->anak->usia_bulan }} bln</td>
            <td>{{ $record->bb_kg }}</td>
            <td>{{ $record->tb_cm }}</td>
            <td>{{ $record->ll_cm ?? '-' }}</td>
            <td><span class="badge badge-{{ $record->status_badge }}">{{ strtoupper($record->status_gizi) }}</span></td>
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
