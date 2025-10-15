@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Registrasi Ibu</h2>
  <a href="{{ route('ibu.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card">
  <form method="POST" action="{{ route('ibu.store') }}">
    @csrf
    
    <div class="row">
      <div class="col">
        <label for="nik">NIK <span style="color:red">*</span></label>
        <input type="text" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" required>
        @error('nik')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <div class="col">
        <label for="nama">Nama Lengkap <span style="color:red">*</span></label>
        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
        @error('nama')<div class="error-msg">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="row">
      <div class="col">
        <label for="tgl_lahir">Tanggal Lahir <span style="color:red">*</span></label>
        <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required>
        @error('tgl_lahir')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <div class="col">
        <label for="hp">No. HP</label>
        <input type="text" id="hp" name="hp" value="{{ old('hp') }}" placeholder="08xx">
        @error('hp')<div class="error-msg">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="row">
      <div class="col-full">
        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat">{{ old('alamat') }}</textarea>
        @error('alamat')<div class="error-msg">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="row">
      <div class="col">
        <label for="posyandu_id">Posyandu <span style="color:red">*</span></label>
        <select id="posyandu_id" name="posyandu_id" required>
          <option value="">- Pilih Posyandu -</option>
          @foreach($posyandus as $p)
            <option value="{{ $p->id }}" {{ old('posyandu_id') == $p->id ? 'selected' : '' }}>
              {{ $p->nama }} - {{ $p->desa }}
            </option>
          @endforeach
        </select>
        @error('posyandu_id')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <div class="col">
        <label for="hpht">HPHT (jika sedang hamil)</label>
        <input type="date" id="hpht" name="hpht" value="{{ old('hpht') }}">
        @error('hpht')<div class="error-msg">{{ $message }}</div>@enderror
        <div class="muted">Hari Pertama Haid Terakhir</div>
      </div>
    </div>

    <div class="mt-2">
      <button type="submit">💾 Simpan Data</button>
      <a href="{{ route('ibu.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
