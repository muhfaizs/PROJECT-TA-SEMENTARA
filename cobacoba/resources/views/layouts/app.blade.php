<!-- resources/views/layouts/app.blade.php -->
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>{{ $title ?? 'SIP Ibu & Anak' }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root { --pri:#145DA0; --bg:#f7f9fc; --card:#fff; --muted:#6b7280; }
    *{box-sizing:border-box} 
    body{margin:0;font-family:system-ui,-apple-system,sans-serif;background:var(--bg);color:#111}
    header{background:var(--pri);color:#fff;padding:12px 16px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap}
    header .brand{font-size:1.2rem;font-weight:700;margin-right:20px}
    nav{display:flex;gap:6px;flex-wrap:wrap}
    nav a{color:#fff;padding:6px 12px;text-decoration:none;border-radius:4px;transition:background .2s}
    nav a:hover{background:rgba(255,255,255,.1)}
    .wrap{max-width:1200px;margin:16px auto;padding:0 12px}
    .card{background:var(--card);border-radius:10px;padding:20px;box-shadow:0 1px 4px rgba(0,0,0,.08);margin-bottom:16px}
    .row{display:flex;gap:16px;flex-wrap:wrap;margin-bottom:12px}
    .col{flex:1 1 300px}
    .col-full{flex:1 1 100%}
    label{display:block;margin:.6rem 0 .3rem;font-weight:600;font-size:.9rem}
    input,select,textarea{width:100%;padding:.7rem;border:1px solid #e5e7eb;border-radius:6px;font-size:.95rem;font-family:inherit}
    input:focus,select:focus,textarea:focus{outline:none;border-color:var(--pri);box-shadow:0 0 0 3px rgba(20,93,160,.1)}
    textarea{min-height:80px;resize:vertical}
    button,.btn{background:#1e90ff;border:none;color:#fff;padding:.7rem 1.2rem;border-radius:6px;cursor:pointer;font-size:.95rem;font-weight:600;text-decoration:none;display:inline-block;transition:background .2s}
    button:hover,.btn:hover{background:#1873cc}
    button:disabled{background:#ccc;cursor:not-allowed}
    .btn-secondary{background:#64748b}
    .btn-secondary:hover{background:#475569}
    .btn-danger{background:#dc2626}
    .btn-danger:hover{background:#b91c1c}
    .btn-sm{padding:.4rem .8rem;font-size:.85rem}
    table{width:100%;border-collapse:collapse;margin-top:12px}
    th{background:#f8fafc;font-weight:600;text-align:left;padding:.8rem;border-bottom:2px solid #e5e7eb}
    td{padding:.8rem;border-bottom:1px solid #f1f5f9}
    tr:hover{background:#f8fafc}
    .muted{color:var(--muted);font-size:.9rem}
    .badge{display:inline-block;padding:3px 10px;border-radius:999px;font-size:.8rem;font-weight:600}
    .badge-primary{background:#dbeafe;color:#1e40af}
    .badge-danger{background:#fee2e2;color:#991b1b}
    .badge-success{background:#d1fae5;color:#065f46}
    .badge-warning{background:#fef3c7;color:#92400e}
    .badge-muted{background:#f1f5f9;color:#64748b}
    .flash{margin-bottom:16px;padding:12px 16px;border-radius:8px;font-weight:500}
    .flash.success{background:#d1fae5;color:#065f46;border:1px solid #86efac}
    .flash.error{background:#fee2e2;color:#991b1b;border:1px solid #fca5a5}
    .error-msg{color:#dc2626;font-size:.85rem;margin-top:4px}
    .stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:20px}
    .stat-card{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;padding:20px;border-radius:10px;box-shadow:0 4px 6px rgba(0,0,0,.1)}
    .stat-card:nth-child(2){background:linear-gradient(135deg,#f093fb 0%,#f5576c 100%)}
    .stat-card:nth-child(3){background:linear-gradient(135deg,#4facfe 0%,#00f2fe 100%)}
    .stat-card:nth-child(4){background:linear-gradient(135deg,#43e97b 0%,#38f9d7 100%)}
    .stat-card h3{margin:0 0 8px;font-size:.9rem;opacity:.9}
    .stat-card .value{font-size:2rem;font-weight:700}
    .pagination{display:flex;gap:6px;margin-top:16px;justify-content:center}
    .pagination a,.pagination span{padding:6px 12px;border:1px solid #e5e7eb;border-radius:4px;text-decoration:none;color:#111}
    .pagination a:hover{background:#f8fafc}
    .pagination .active{background:var(--pri);color:#fff;border-color:var(--pri)}
    .search-box{display:flex;gap:8px;margin-bottom:16px}
    .search-box input{flex:1}
    h1,h2,h3{margin-top:0;color:#1e293b}
    h2{font-size:1.5rem;margin-bottom:16px}
    .text-right{text-align:right}
    .mb-2{margin-bottom:16px}
    .mt-2{margin-top:16px}
    .flex{display:flex}
    .justify-between{justify-content:space-between}
    .items-center{align-items:center}
    .gap-2{gap:8px}
  </style>
</head>
<body>
<header>
  <div class="brand">🏥 SIP Ibu & Anak</div>
  <nav>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="{{ route('ibu.index') }}">Ibu</a>
    <a href="{{ route('anak.index') }}">Anak</a>
    <a href="{{ route('tumbuh.index') }}">Tumbuh</a>
    <a href="{{ route('imunisasi.index') }}">Imunisasi</a>
    @if(in_array(auth()->user()->role ?? '', ['bidan','dokter','admin']))
      <a href="{{ route('verifikasi.index') }}">Verifikasi</a>
    @endif
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault();document.getElementById('logout-form').submit()">Keluar</a>
    <form id="logout-form" action="{{ route('logout') }}" method="post" style="display:none">@csrf</form>
  </nav>
</header>
<main class="wrap">
  @if(session('success'))
    <div class="flash success">✓ {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="flash error">✗ {{ session('error') }}</div>
  @endif
  @if($errors->any())
    <div class="flash error">
      <strong>Terjadi kesalahan:</strong>
      <ul style="margin:8px 0 0;padding-left:20px">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  
  @yield('content')
</main>
</body>
</html>
