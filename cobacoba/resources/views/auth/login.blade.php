@extends('layouts.app')

@section('content')
<div class="card" style="max-width:400px;margin:80px auto">
  <h2 style="text-align:center;margin-bottom:24px">Login</h2>
  
  <form method="POST" action="{{ route('login.post') }}">
    @csrf
    
    <div>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
      @error('email')
        <div class="error-msg">{{ $message }}</div>
      @enderror
    </div>

    <div style="margin-top:16px">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      @error('password')
        <div class="error-msg">{{ $message }}</div>
      @enderror
    </div>

    <div style="margin-top:16px">
      <label style="display:flex;align-items:center;font-weight:normal">
        <input type="checkbox" name="remember" style="width:auto;margin-right:8px">
        Ingat saya
      </label>
    </div>

    <div style="margin-top:24px">
      <button type="submit" style="width:100%">Login</button>
    </div>
  </form>
</div>
@endsection
