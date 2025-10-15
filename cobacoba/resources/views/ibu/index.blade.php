@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Data Ibu</h2>
  <a href="{{ route('ibu.create') }}" class="btn">➕ Registrasi Ibu</a>
</div>

<div class="card">
  <form method="GET" class="search-box">
    <input type="text" name="search" placeholder="Cari nama atau NIK..." value="{{ request('search') }}">
    <select name="posyandu_id" style="width:auto">
      <option value="">Semua Posyandu</option>
      @foreach($posyandus as $p)
        <option value="{{ $p->id }}" {{ request('posyandu_id') == $p->id ? 'selected' : '' }}>
          {{ $p->nama }}
        </option>
      @endforeach
    </select>
    <button type="submit">🔍 Cari</button>
    @if(request()->hasAny(['search', 'posyandu_id']))
      <a href="{{ route('ibu.index') }}" class="btn btn-secondary">Reset</a>
    @endif
  </form>

  @if($list->count() > 0)
    <table>
      <thead>
        <tr>
          <th>NIK</th>
          <th>Nama</th>
          <th>Usia</th>
          <th>Posyandu</th>
          <th>Status Hamil</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($list as $ibu)
          <tr>
            <td class="muted">{{ substr($ibu->nik, 0, 4) }}...{{ substr($ibu->nik, -4) }}</td>
            <td>
              <strong>{{ $ibu->nama }}</strong>
              @if($ibu->hp)
                <div class="muted">{{ $ibu->hp }}</div>
              @endif
            </td>
            <td>{{ $ibu->usia }} tahun</td>
            <td>{{ $ibu->posyandu->nama }}</td>
            <td>
              @if($ibu->hpht)
                <span class="badge badge-primary">Hamil {{ $ibu->usia_kehamilan }} minggu</span>
                @if($ibu->risk_score > 5)
                  <span class="badge badge-danger">Risiko Tinggi</span>
                @endif
              @else
                <span class="badge badge-muted">Tidak hamil</span>
              @endif
            </td>
            <td>
              <a href="{{ route('ibu.show', $ibu->id) }}" class="btn btn-sm">Detail</a>
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
