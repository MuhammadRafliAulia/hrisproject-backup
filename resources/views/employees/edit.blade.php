<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Karyawan</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; display:flex; height:100vh; }
    .sidebar { width:280px; background:#fff; border-right:1px solid #e2e8f0; padding:20px; box-sizing:border-box; }
    .sidebar h2 { font-size:16px; color:#0f172a; margin:0 0 16px 0; font-weight:600; }
    .sidebar-menu { list-style:none; margin:0; padding:0; }
    .sidebar-menu li { margin-bottom:8px; }
    .sidebar-menu a { display:block; padding:10px 12px; color:#334155; text-decoration:none; border-radius:6px; font-size:14px; }
    .sidebar-menu a:hover { background:#f1f5f9; }
    .main { flex:1; display:flex; flex-direction:column; }
    .topbar { background:#fff; border-bottom:1px solid #e2e8f0; padding:16px 24px; }
    .topbar h1 { margin:0; font-size:20px; color:#0f172a; }
    .content { flex:1; padding:24px; overflow-y:auto; }
    .card { background:#fff; border:1px solid #e2e8f0; padding:24px; border-radius:8px; max-width:600px; }
    h2 { font-size:18px; color:#0f172a; margin:0 0 20px 0; }
    label { display:block; font-size:13px; color:#334155; margin-bottom:6px; margin-top:14px; }
    input, select { width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px; color:#0f172a; box-sizing:border-box; font-family:inherit; }
    .btn { background:#003e6f; color:#fff; border:none; padding:10px 12px; border-radius:6px; font-size:14px; cursor:pointer; margin-top:20px; }
    .btn-cancel { background:#64748b; margin-left:8px; }
    .error { color:#dc2626; font-size:12px; margin-top:4px; }
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
      <li><a href="{{ route('banks.index') }}">📋 Psikotest Online</a></li>
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
      <h1>Edit Karyawan</h1>
    </div>
    
    <div class="content">
      <div class="card">
        <h2>{{ $employee->nama }}</h2>
        <form method="POST" action="{{ route('employees.update', $employee) }}">
          @csrf @method('PUT')

          <label for="nama">Nama</label>
          <input id="nama" type="text" name="nama" value="{{ $employee->nama }}" required>
          @error('nama')<div class="error">{{ $message }}</div>@enderror

          <label for="jabatan">Jabatan</label>
          <input id="jabatan" type="text" name="jabatan" value="{{ $employee->jabatan }}" required>
          @error('jabatan')<div class="error">{{ $message }}</div>@enderror

          <label for="status">Status</label>
          <select id="status" name="status" required>
            <option value="kontrak" {{ $employee->status === 'kontrak' ? 'selected' : '' }}>Kontrak</option>
            <option value="tetap" {{ $employee->status === 'tetap' ? 'selected' : '' }}>Tetap</option>
          </select>
          @error('status')<div class="error">{{ $message }}</div>@enderror

          <div>
            <button type="submit" class="btn">Simpan Perubahan</button>
            <a href="{{ route('employees.index') }}" class="btn btn-cancel" style="text-decoration:none;">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
