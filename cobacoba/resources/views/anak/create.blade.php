@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-2">
  <h2>Registrasi Anak</h2>
  <a href="{{ route('anak.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card">
  <form method="POST" action="{{ route('anak.store') }}">
    @csrf
    
    <div class="row">
      <div class="col">
        <label for="ibu_id">Nama Ibu <span style="color:red">*</span></label>
        <select id="ibu_id" name="ibu_id" required>
          <option value="">- Pilih Ibu -</option>
          @foreach($ibus as $i)
            <option value="{{ $i->id }}" {{ (old('ibu_id') ?? $selectedIbu?->id) == $i->id ? 'selected' : '' }}>
              {{ $i->nama }} - {{ $i->posyandu->nama }}
            </option>
          @endforeach
        </select>
        @error('ibu_id')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <div class="col">
        <label for="nik">NIK Anak (opsional)</label>
        <input type="text" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16">
        @error('nik')<div class="error-msg">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="row">
      <div class="col">
        <label for="nama">Nama Anak <span style="color:red">*</span></label>
        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
        @error('nama')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <div class="col">
        <label for="jk">Jenis Kelamin <span style="color:red">*</span></label>
        <select id="jk" name="jk" required>
          <option value="">- Pilih -</option>
          <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
          <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jk')<div class="error-msg">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="row">
      <div class="col">
        <label for="tgl_lahir">Tanggal Lahir <span style="color:red">*</span></label>
        <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required>
        @error('tgl_lahir')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <div class="col">
        <label for="bb_lahir">Berat Lahir (kg)</label>
        <input type="number" id="bb_lahir" name="bb_lahir" value="{{ old('bb_lahir') }}" step="0.01" min="0.5" max="10">
        @error('bb_lahir')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <div class="col">
        <label for="tb_lahir">Panjang Lahir (cm)</label>
        <input type="number" id="tb_lahir" name="tb_lahir" value="{{ old('tb_lahir') }}" step="0.1" min="20" max="100">
        @error('tb_lahir')<div class="error-msg">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="mt-2">
      <button type="submit">💾 Simpan Data</button>
      <a href="{{ route('anak.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
