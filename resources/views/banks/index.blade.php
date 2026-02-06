<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Psikotest Online</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; display:flex; height:100vh; }
    .sidebar { width:280px; background:#fff; border-right:1px solid #e2e8f0; padding:20px; box-sizing:border-box; overflow-y:auto; }
    .sidebar h2 { font-size:16px; color:#0f172a; margin:0 0 16px 0; font-weight:600; }
    .sidebar-menu { list-style:none; margin:0; padding:0; }
    .sidebar-menu li { margin-bottom:8px; }
    .sidebar-menu a { display:block; padding:10px 12px; color:#334155; text-decoration:none; border-radius:6px; font-size:14px; transition:all 0.2s; }
    .sidebar-menu a:hover { background:#f1f5f9; color:#0f172a; }
    .sidebar-menu a.active { background:#dbeafe; color:#0c4a6e; font-weight:500; }
    .main { flex:1; display:flex; flex-direction:column; }
    .topbar { background:#fff; border-bottom:1px solid #e2e8f0; padding:16px 24px; display:flex; justify-content:space-between; align-items:center; }
    .topbar h1 { margin:0; font-size:20px; color:#0f172a; }
    .content { flex:1; padding:24px; overflow-y:auto; }
    .card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:20px; margin-bottom:20px; }
    .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .header h2 { margin:0; font-size:18px; color:#0f172a; }
    .btn { background:#003e6f; color:#fff; border:none; padding:8px 14px; border-radius:6px; font-size:14px; cursor:pointer; text-decoration:none; display:inline-block; }
    .btn-small { padding:6px 10px; font-size:12px; }
    .btn-danger { background:#dc2626; }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:12px; text-align:left; border-bottom:1px solid #e2e8f0; font-size:14px; }
    th { background:#f1f5f9; color:#334155; font-weight:600; }
    .empty { text-align:center; color:#64748b; padding:40px; }
    .success { background:#d1fae5; color:#065f46; padding:12px; border-radius:6px; margin-bottom:16px; font-size:13px; }
    .user-section { border-top:1px solid #e2e8f0; padding-top:16px; margin-top:16px; }
    .user-name { font-size:13px; color:#475569; margin-bottom:12px; }
    .btn-logout { width:100%; text-align:center; background:#003e6f; }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Menu</h2>
    <ul class="sidebar-menu">
      <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li><a href="{{ route('banks.index') }}" class="active">📋 Psikotest Online</a></li>
      <li><a href="{{ route('employees.index') }}">👥 Database Karyawan</a></li>
    </ul>
    
    <div class="user-section">
      <div class="user-name">👤 {{ auth()->user()->name }}</div>
      <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit" class="btn btn-logout">Logout</button>
      </form>
    </div>
  </div>

  <div class="main">
    <div class="topbar">
      <h1>Psikotest Online</h1>
    </div>
    
    <div class="content">
      @if(session('success'))
        <div class="success">{{ session('success') }}</div>
      @endif

      <div class="card">
        <div class="header">
          <h2>Bank Soal</h2>
          <a href="{{ route('banks.create') }}" class="btn">+ Bank Baru</a>
        </div>

        @if($banks->count() > 0)
          <table>
            <thead>
              <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($banks as $bank)
                <tr>
                  <td>{{ $bank->title }}</td>
                  <td>{{ Str::limit($bank->description ?? '-', 50) }}</td>
                  <td>
                    <a href="{{ route('banks.edit', $bank) }}" class="btn btn-small" style="background:#3b82f6;">Edit</a>
                    <a href="{{ route('banks.results', $bank) }}" class="btn btn-small" style="background:#10b981;">Hasil</a>
                    <form method="POST" action="{{ route('banks.destroy', $bank) }}" style="display:inline;">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-small btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="empty">Belum ada bank soal. Buat bank soal baru untuk memulai.</div>
        @endif
      </div>

      <div style="text-align:center; color:#64748b; font-size:12px; margin-top:20px;">
        copyright @2026 Shindengen HR Internal Team
      </div>
    </div>
  </div>
</body>
</html>

