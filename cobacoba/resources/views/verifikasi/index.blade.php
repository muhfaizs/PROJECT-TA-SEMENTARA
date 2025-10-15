@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Verifikasi Data</h2>
  <div class="muted">{{ $items->count() }} data menunggu verifikasi</div>
</div>

<div class="card">
  <form method="GET" class="search-box">
    <select name="type" style="width:auto">
      <option value="">Semua Tipe</option>
      <option value="tumbuh" {{ request('type') == 'tumbuh' ? 'selected' : '' }}>Pengukuran</option>
      <option value="imunisasi" {{ request('type') == 'imunisasi' ? 'selected' : '' }}>Imunisasi</option>
    </select>
    <button type="submit">🔍 Filter</button>
    @if(request('type'))
      <a href="{{ route('verifikasi.index') }}" class="btn btn-secondary">Reset</a>
    @endif
  </form>

  @if($items->count() > 0)
    <table>
      <thead>
        <tr>
          <th style="width:100px">Jenis</th>
          <th>Nama Anak</th>
          <th>Nama Ibu</th>
          <th>Tanggal</th>
          <th>Detail</th>
          <th>Posyandu</th>
          <th>Dibuat Oleh</th>
          <th style="width:200px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($items as $item)
          <tr>
            <td><span class="badge badge-primary">{{ $item['type_label'] }}</span></td>
            <td><strong>{{ $item['nama'] }}</strong></td>
            <td class="muted">{{ $item['nama_ibu'] }}</td>
            <td>{{ $item['tanggal'] }}</td>
            <td class="muted">{{ $item['ringkas'] }}</td>
            <td>{{ $item['posyandu'] }}</td>
            <td class="muted">{{ $item['created_by'] }}</td>
            <td>
              <form method="POST" action="{{ route('verifikasi.approve', $item['id']) }}" style="display:inline">
                @csrf
                <input type="hidden" name="type" value="{{ $item['type'] }}">
                <button type="submit" class="btn btn-sm" style="background:#10b981" onclick="return confirm('Approve data ini?')">
                  ✓ Approve
                </button>
              </form>
              <button type="button" class="btn btn-sm btn-danger" onclick="showRejectForm({{ $item['id'] }}, '{{ $item['type'] }}')">
                ✗ Reject
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="muted text-center" style="padding:40px 0">✓ Semua data sudah diverifikasi</p>
  @endif
</div>

<!-- Modal Reject (Simple) -->
<div id="rejectModal" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.5);z-index:1000;align-items:center;justify-content:center">
  <div class="card" style="max-width:500px;margin:20px">
    <h3>Alasan Penolakan</h3>
    <form id="rejectForm" method="POST">
      @csrf
      <input type="hidden" name="type" id="rejectType">
      <textarea name="reject_reason" rows="4" placeholder="Masukkan alasan penolakan..." style="margin-top:12px"></textarea>
      <div style="margin-top:12px;display:flex;gap:8px">
        <button type="submit" class="btn btn-danger">Reject</button>
        <button type="button" class="btn btn-secondary" onclick="closeRejectForm()">Batal</button>
      </div>
    </form>
  </div>
</div>

<script>
function showRejectForm(id, type) {
  document.getElementById('rejectForm').action = '{{ route("verifikasi.reject", ":id") }}'.replace(':id', id);
  document.getElementById('rejectType').value = type;
  document.getElementById('rejectModal').style.display = 'flex';
}
function closeRejectForm() {
  document.getElementById('rejectModal').style.display = 'none';
}
</script>
@endsection
