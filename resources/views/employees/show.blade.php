<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Detail Karyawan</title>
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
    .card { background:#fff; border:1px solid #e2e8f0; padding:24px; border-radius:8px; max-width:700px; }
    h2 { font-size:18px; color:#0f172a; margin:0 0 20px 0; }
    .row { display:flex; margin-bottom:10px; }
    .row label { width:220px; color:#334155; font-size:13px; font-weight:600; }
    .row span { flex:1; color:#0f172a; font-size:14px; }
    .user-section { border-top:1px solid #e2e8f0; padding-top:16px; margin-top:16px; }
    .user-name { font-size:13px; color:#475569; margin-bottom:12px; }
    .btn-logout { width:100%; text-align:center; background:#003e6f; }
    .btn-back { background:#64748b; color:#fff; border:none; padding:8px 14px; border-radius:6px; font-size:14px; cursor:pointer; text-decoration:none; display:inline-block; margin-top:20px; }
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
        <button type="submit" class="btn btn-danger btn-logout">Logout</button>
      </form>
    </div>
  </div>
  <div class="main">
    <div class="topbar">
      <h1>Detail Karyawan</h1>
    </div>
    <div class="content">
      <div class="card">
        <h2>{{ $employee->nama }}</h2>
        @php
        $fields = [
          'NIK' => 'nik', 'NAMA' => 'nama', 'GOL' => 'gol', 'DEPT' => 'dept', 'JABATAN' => 'jabatan', 'SEKSI' => 'seksi',
          'TEMPAT LAHIR' => 'tempat_lahir', 'TGL. LAHIR' => 'tgl_lahir', 'GOL. DARAH' => 'gol_darah', 'ALAMAT DOMISILI' => 'alamat_domisili',
          'STATUS TEMPAT TINGGAL' => 'status_tempat_tinggal', 'NO TELPON' => 'no_telpon', 'NO. WA' => 'no_wa', 'PIHAK YANG DAPAT DIHUBUNGI SAAT DARURAT' => 'kontak_darurat',
          'TGL. MASUK' => 'tgl_masuk', 'BULAN MASUK' => 'bulan_masuk', 'TAHUN MASUK' => 'tahun_masuk', 'STATUS' => 'status_karyawan',
          'STATUS PPH' => 'status_pph', 'END PKWT 1' => 'end_pkwt_1', 'END PKWT 2' => 'end_pkwt_2', 'TGL. PENGANGKATAN' => 'tgl_pengangkatan',
          'TGL SEKARANG' => 'tgl_sekarang', 'MASA KERJA DIA' => 'masa_kerja', 'USIA' => 'usia', 'NPWP' => 'npwp', 'JAMSOSTEK' => 'jamsostek',
          'NO KPJ BPJSTK' => 'no_kpj_bpjstk', 'NO.KK' => 'no_kk', 'KTP' => 'ktp', 'ALAMAT EMAIL' => 'alamat_email',
          'STATUS PERKAWINAN' => 'status_perkawinan', 'STATUS PERKAWINAN (EXCEL)' => 'status_perkawinan_excel', 'PENDIDIKAN' => 'pendidikan',
          'ASAL SEKOLAH' => 'asal_sekolah', 'A.R.' => 'ar', 'END' => 'end', 'BULAN END' => 'bulan_end', 'STATUS (AKTIF/TIDAK AKTIF)' => 'status_aktif',
          'ALAMAT NPWP' => 'alamat_npwp', 'ALAMAT ASAL' => 'alamat_asal', 'AGAMA' => 'agama', 'ASAL KOTA' => 'asal_kota',
          'ALAMAT DOMISILI KECAMATAN' => 'alamat_domisili_kecamatan', 'AREA ASAL KECAMATAN' => 'area_asal_kecamatan', 'AREA ASAL' => 'area_asal',
        ];
        @endphp
        @foreach($fields as $label => $field)
        <div class="row">
          <label>{{ $label }}</label>
          <span>{{ $employee->$field }}</span>
        </div>
        @endforeach
        <a href="{{ route('employees.index') }}" class="btn-back">Kembali</a>
      </div>
    </div>
  </div>
</body>
</html>
