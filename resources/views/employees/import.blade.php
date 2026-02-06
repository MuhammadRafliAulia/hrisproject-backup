<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Import Karyawan</title>
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
    h2 { font-size:18px; color:#0f172a; margin:0 0 16px 0; }
    .info { background:#dbeafe; color:#0c4a6e; padding:12px; border-radius:6px; margin-bottom:20px; font-size:13px; }
    .info strong { display:block; margin-bottom:6px; }
    label { display:block; font-size:13px; color:#334155; margin-bottom:6px; margin-top:14px; }
    input[type=file] { width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px; box-sizing:border-box; }
    .btn { background:#003e6f; color:#fff; border:none; padding:10px 12px; border-radius:6px; font-size:14px; cursor:pointer; margin-top:20px; }
    .btn-cancel { background:#64748b; margin-left:8px; }
    .btn-template { background:#10b981; }
    .error { color:#dc2626; font-size:12px; margin-top:4px; }
    .user-section { border-top:1px solid #e2e8f0; padding-top:16px; margin-top:16px; }
    .user-name { font-size:13px; color:#475569; margin-bottom:12px; }
    .btn-logout { width:100%; text-align:center; background:#003e6f; }
  </style>
</head>
<body>
  @include('layouts.sidebar')

  <div class="main">
    <div class="topbar">
      <h1>Import Karyawan</h1>
    </div>
    
    <div class="content">
      <div class="card">
        <h2>Import dari File CSV</h2>
        
        <div class="info">
          <strong>Format File:</strong>
          Pastikan file CSV memiliki kolom: nama, jabatan, status (kontrak/tetap)
          <br>
          <a href="{{ route('employees.template') }}" style="color:#0c4a6e; text-decoration:underline;">Unduh template CSV</a>
        </div>

        <form method="POST" action="{{ route('employees.import') }}" enctype="multipart/form-data">
          @csrf

          <label for="file">Pilih File CSV</label>
          <input id="file" type="file" name="file" accept=".csv,.txt" required>
          @error('file')<div class="error">{{ $message }}</div>@enderror

          <div>
            <button type="submit" class="btn">📥 Import</button>
            <a href="{{ route('employees.index') }}" class="btn btn-cancel" style="text-decoration:none;">Batal</a>
          </div>
        </form>

        <div style="margin-top:24px; padding:16px; background:#fef08a; border-radius:6px; border-left:3px solid #713f12;">
          <strong style="color:#713f12;">ℹ️ Catatan:</strong>
          <ul style="margin:8px 0 0 0; color:#713f12; font-size:13px;">
            <li>Format file harus CSV atau TXT</li>
            <li>Ukuran maksimal 2MB</li>
            <li>Baris pertama adalah header (nama, jabatan, status)</li>
            <li>Status hanya boleh "kontrak" atau "tetap"</li>
            <li>Data yang tidak valid akan ditampilkan di pesan error</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
