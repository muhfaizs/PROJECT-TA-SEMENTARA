<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>{{ $title ?? 'SiBunda' }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { 
      --pri:#667eea; 
      --pri-dark:#764ba2;
      --bg:#f8fafc; 
      --card:#fff; 
      --muted:#64748b;
      --border:#e2e8f0;
      --text:#1e293b;
      --success:#10b981;
      --danger:#ef4444;
      --warning:#f59e0b;
      --info:#3b82f6;
    }
    
    *{box-sizing:border-box;margin:0;padding:0} 
    
    body{
      font-family:'Poppins',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
      background:var(--bg);
      color:var(--text);
      line-height:1.6;
    }
    
    /* Header Styles */
    header{
      background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
      color:#fff;
      padding:16px 24px;
      box-shadow:0 4px 20px rgba(102,126,234,0.15);
      position:sticky;
      top:0;
      z-index:100;
      backdrop-filter:blur(10px);
    }
    
    .header-content{
      max-width:1400px;
      margin:0 auto;
      display:flex;
      justify-content:space-between;
      align-items:center;
      flex-wrap:wrap;
      gap:16px;
    }
    
    .brand{
      font-size:1.4rem;
      font-weight:700;
      display:flex;
      align-items:center;
      gap:10px;
      letter-spacing:-0.5px;
    }
    
    .brand-icon{
      font-size:1.8rem;
      animation:pulse 2s infinite;
    }
    
    @keyframes pulse{
      0%,100%{transform:scale(1)}
      50%{transform:scale(1.1)}
    }
    
    nav{
      display:flex;
      gap:4px;
      flex-wrap:wrap;
      align-items:center;
    }
    
    nav a{
      color:#fff;
      padding:10px 18px;
      text-decoration:none;
      border-radius:10px;
      transition:all 0.3s ease;
      font-weight:500;
      font-size:0.95rem;
      position:relative;
      overflow:hidden;
    }
    
    nav a:before{
      content:'';
      position:absolute;
      top:0;
      left:0;
      width:100%;
      height:100%;
      background:rgba(255,255,255,0.1);
      transform:translateX(-100%);
      transition:transform 0.3s ease;
    }
    
    nav a:hover:before{
      transform:translateX(0);
    }
    
    nav a:hover{
      background:rgba(255,255,255,0.15);
      transform:translateY(-2px);
    }
    
    nav a.active{
      background:rgba(255,255,255,0.2);
      box-shadow:0 4px 15px rgba(0,0,0,0.1);
    }
    
    /* Main Content */
    .wrap{
      max-width:1400px;
      margin:24px auto;
      padding:0 24px;
    }
    
    /* Card Styles */
    .card{
      background:var(--card);
      border-radius:16px;
      padding:28px;
      box-shadow:0 2px 12px rgba(0,0,0,0.06);
      margin-bottom:24px;
      border:1px solid var(--border);
      transition:all 0.3s ease;
    }
    
    .card:hover{
      box-shadow:0 8px 30px rgba(0,0,0,0.12);
      transform:translateY(-2px);
    }
    
    /* Form Elements */
    .row{display:flex;gap:20px;flex-wrap:wrap;margin-bottom:16px}
    .col{flex:1 1 300px}
    .col-full{flex:1 1 100%}
    
    label{
      display:block;
      margin:0 0 8px;
      font-weight:600;
      font-size:0.9rem;
      color:var(--text);
    }
    
    input,select,textarea{
      width:100%;
      padding:12px 16px;
      border:2px solid var(--border);
      border-radius:10px;
      font-size:0.95rem;
      font-family:inherit;
      transition:all 0.3s ease;
      background:var(--bg);
    }
    
    input:focus,select:focus,textarea:focus{
      outline:none;
      border-color:var(--pri);
      background:var(--card);
      box-shadow:0 0 0 4px rgba(102,126,234,0.1);
    }
    
    textarea{min-height:100px;resize:vertical}
    
    /* Buttons */
    button,.btn{
      background:linear-gradient(135deg,var(--pri) 0%,var(--pri-dark) 100%);
      border:none;
      color:#fff;
      padding:12px 24px;
      border-radius:10px;
      cursor:pointer;
      font-size:0.95rem;
      font-weight:600;
      text-decoration:none;
      display:inline-flex;
      align-items:center;
      gap:8px;
      transition:all 0.3s ease;
      box-shadow:0 4px 15px rgba(102,126,234,0.3);
      font-family:inherit;
    }
    
    button:hover,.btn:hover{
      transform:translateY(-2px);
      box-shadow:0 6px 25px rgba(102,126,234,0.4);
    }
    
    button:active,.btn:active{
      transform:translateY(0);
    }
    
    button:disabled{
      opacity:0.5;
      cursor:not-allowed;
      transform:none;
    }
    
    .btn-secondary{
      background:linear-gradient(135deg,#64748b 0%,#475569 100%);
      box-shadow:0 4px 15px rgba(100,116,139,0.3);
    }
    
    .btn-danger{
      background:linear-gradient(135deg,#ef4444 0%,#dc2626 100%);
      box-shadow:0 4px 15px rgba(239,68,68,0.3);
    }
    
    .btn-success{
      background:linear-gradient(135deg,#10b981 0%,#059669 100%);
      box-shadow:0 4px 15px rgba(16,185,129,0.3);
    }
    
    .btn-sm{padding:8px 16px;font-size:0.85rem}
    
    /* Table Styles */
    table{
      width:100%;
      border-collapse:separate;
      border-spacing:0;
      margin-top:16px;
      overflow:hidden;
      border-radius:12px;
    }
    
    th{
      background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
      color:#fff;
      font-weight:600;
      text-align:left;
      padding:14px 16px;
      border:none;
    }
    
    th:first-child{border-top-left-radius:12px}
    th:last-child{border-top-right-radius:12px}
    
    td{
      padding:14px 16px;
      border-bottom:1px solid var(--border);
      background:var(--card);
    }
    
    tr:hover td{
      background:var(--bg);
    }
    
    tr:last-child td{border-bottom:none}
    
    /* Badges */
    .badge{
      display:inline-flex;
      align-items:center;
      padding:6px 14px;
      border-radius:50px;
      font-size:0.8rem;
      font-weight:600;
      gap:4px;
    }
    
    .badge-primary{background:#dbeafe;color:#1e40af}
    .badge-danger{background:#fee2e2;color:#991b1b}
    .badge-success{background:#d1fae5;color:#065f46}
    .badge-warning{background:#fef3c7;color:#92400e}
    .badge-muted{background:#f1f5f9;color:#64748b}
    
    /* Flash Messages */
    .flash{
      margin-bottom:24px;
      padding:16px 20px;
      border-radius:12px;
      font-weight:500;
      display:flex;
      align-items:center;
      gap:12px;
      animation:slideDown 0.3s ease-out;
      box-shadow:0 4px 15px rgba(0,0,0,0.1);
    }
    
    @keyframes slideDown{
      from{opacity:0;transform:translateY(-20px)}
      to{opacity:1;transform:translateY(0)}
    }
    
    .flash.success{
      background:#d1fae5;
      color:#065f46;
      border-left:4px solid #10b981;
    }
    
    .flash.error{
      background:#fee2e2;
      color:#991b1b;
      border-left:4px solid #ef4444;
    }
    
    .error-msg{
      color:var(--danger);
      font-size:0.85rem;
      margin-top:6px;
      display:flex;
      align-items:center;
      gap:4px;
    }
    
    /* Stats Cards */
    .stats{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
      gap:20px;
      margin-bottom:32px;
    }
    
    .stat-card{
      background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);
      color:#fff;
      padding:24px;
      border-radius:16px;
      box-shadow:0 8px 30px rgba(102,126,234,0.3);
      transition:all 0.3s ease;
      position:relative;
      overflow:hidden;
    }
    
    .stat-card:before{
      content:'';
      position:absolute;
      top:-50%;
      right:-50%;
      width:200%;
      height:200%;
      background:radial-gradient(circle,rgba(255,255,255,0.1) 0%,transparent 70%);
      pointer-events:none;
    }
    
    .stat-card:hover{
      transform:translateY(-4px);
      box-shadow:0 12px 40px rgba(102,126,234,0.4);
    }
    
    .stat-card:nth-child(2){background:linear-gradient(135deg,#f093fb 0%,#f5576c 100%)}
    .stat-card:nth-child(3){background:linear-gradient(135deg,#4facfe 0%,#00f2fe 100%)}
    .stat-card:nth-child(4){background:linear-gradient(135deg,#43e97b 0%,#38f9d7 100%)}
    
    .stat-card h3{
      margin:0 0 12px;
      font-size:0.9rem;
      opacity:0.95;
      font-weight:500;
    }
    
    .stat-card .value{
      font-size:2.5rem;
      font-weight:700;
      line-height:1;
    }
    
    /* Pagination */
    .pagination{
      display:flex;
      gap:8px;
      margin-top:24px;
      justify-content:center;
      flex-wrap:wrap;
    }
    
    .pagination a,.pagination span{
      padding:10px 16px;
      border:2px solid var(--border);
      border-radius:10px;
      text-decoration:none;
      color:var(--text);
      font-weight:500;
      transition:all 0.3s ease;
      min-width:44px;
      text-align:center;
    }
    
    .pagination a:hover{
      background:var(--pri);
      color:#fff;
      border-color:var(--pri);
      transform:translateY(-2px);
    }
    
    .pagination .active{
      background:linear-gradient(135deg,var(--pri) 0%,var(--pri-dark) 100%);
      color:#fff;
      border-color:var(--pri);
      box-shadow:0 4px 15px rgba(102,126,234,0.3);
    }
    
    /* Search Box */
    .search-box{
      display:flex;
      gap:12px;
      margin-bottom:20px;
      flex-wrap:wrap;
    }
    
    .search-box input{flex:1;min-width:250px}
    
    /* Headings */
    h1,h2,h3{margin-top:0;color:var(--text);font-weight:700}
    h1{font-size:2rem;margin-bottom:8px}
    h2{font-size:1.6rem;margin-bottom:20px}
    h3{font-size:1.2rem;margin-bottom:16px}
    
    /* Utility Classes */
    .text-right{text-align:right}
    .text-center{text-align:center}
    .mb-2{margin-bottom:16px}
    .mt-2{margin-top:16px}
    .flex{display:flex}
    .justify-between{justify-content:space-between}
    .items-center{align-items:center}
    .gap-2{gap:12px}
    .muted{color:var(--muted);font-size:0.9rem}
    
    /* Responsive */
    @media(max-width:768px){
      .wrap{padding:0 16px}
      .card{padding:20px}
      nav{width:100%;justify-content:center}
      .stats{grid-template-columns:1fr}
      h1{font-size:1.6rem}
      h2{font-size:1.3rem}
    }
  </style>
</head>
<body>
<header>
  <div class="header-content">
    <div class="brand">
      <span class="brand-icon">🏥</span>
      <span>SiBunda</span>
    </div>
    <nav>
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">📊 Dashboard</a>
      <a href="{{ route('ibu.index') }}" class="{{ request()->routeIs('ibu.*') ? 'active' : '' }}">👩 Ibu</a>
      <a href="{{ route('anak.index') }}" class="{{ request()->routeIs('anak.*') ? 'active' : '' }}">👶 Anak</a>
      <a href="{{ route('tumbuh.index') }}" class="{{ request()->routeIs('tumbuh.*') ? 'active' : '' }}">📈 Tumbuh</a>
      <a href="{{ route('imunisasi.index') }}" class="{{ request()->routeIs('imunisasi.*') ? 'active' : '' }}">💉 Imunisasi</a>
      @if(in_array(auth()->user()->role ?? '', ['bidan','dokter','admin']))
        <a href="{{ route('verifikasi.index') }}" class="{{ request()->routeIs('verifikasi.*') ? 'active' : '' }}">✅ Verifikasi</a>
      @endif
      <a href="{{ route('logout') }}"
         onclick="event.preventDefault();document.getElementById('logout-form').submit()"
         style="background:rgba(239,68,68,0.2)">🚪 Keluar</a>
      <form id="logout-form" action="{{ route('logout') }}" method="post" style="display:none">@csrf</form>
    </nav>
  </div>
</header>
<main class="wrap">
  @if(session('success'))
    <div class="flash success">
      <span style="font-size:1.5rem">✓</span>
      <span>{{ session('success') }}</span>
    </div>
  @endif
  @if(session('error'))
    <div class="flash error">
      <span style="font-size:1.5rem">✗</span>
      <span>{{ session('error') }}</span>
    </div>
  @endif
  @if($errors->any())
    <div class="flash error">
      <div>
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin:8px 0 0;padding-left:20px">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif
  
  @yield('content')
</main>
</body>
</html>
