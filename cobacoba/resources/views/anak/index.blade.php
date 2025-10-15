@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Data Anak</h2>
  <a href="{{ route('anak.create') }}" class="btn">➕ Registrasi Anak</a>
</div>

<div class="card">
  <form method="GET" class="search-box">
    <input type="text" name="search" placeholder="Cari nama anak atau nama ibu..." value="{{ request('search') }}">
    <button type="submit">🔍 Cari</button>
    @if(request('search'))
      <a href="{{ route('anak.index') }}" class="btn btn-secondary">Reset</a>
    @endif
  </form>

  @if($list->count() > 0)
    <table>
      <thead>
        <tr>
          <th>Nama Anak</th>
          <th>Nama Ibu</th>
          <th>Tgl Lahir</th>
          <th>Usia</th>
          <th>JK</th>
          <th>Posyandu</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($list as $anak)
          <tr>
            <td><strong>{{ $anak->nama }}</strong></td>
            <td>{{ $anak->ibu->nama }}</td>
            <td>{{ $anak->tgl_lahir->format('d/m/Y') }}</td>
            <td>
              {{ $anak->usia_tahun }} tahun {{ $anak->usia_bulan % 12 }} bulan
            </td>
            <td>{{ $anak->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td>{{ $anak->ibu->posyandu->nama }}</td>
            <td>
              <a href="{{ route('anak.show', $anak->id) }}" class="btn btn-sm">Detail</a>
              <a href="{{ route('tumbuh.create', $anak->id) }}" class="btn btn-sm" style="background:#10b981">Ukur</a>
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
