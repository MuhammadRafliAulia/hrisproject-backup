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
  @include('layouts.sidebar')

  <div class="main">
    <div class="topbar">
      <h1>Edit Karyawan</h1>
    </div>
    
    <div class="content">
      <div class="card">
        <h2>{{ $employee->nama }}</h2>
        <form method="POST" action="{{ route('employees.update', $employee) }}">
          @csrf @method('PUT')

          @php
          $fields = [
            ['NIK', 'nik'], ['NAMA', 'nama'], ['GOL', 'gol'], ['DEPT', 'dept'], ['JABATAN', 'jabatan'], ['SEKSI', 'seksi'],
            ['TEMPAT LAHIR', 'tempat_lahir'], ['TGL. LAHIR', 'tgl_lahir', 'date'], ['GOL. DARAH', 'gol_darah'], ['ALAMAT DOMISILI', 'alamat_domisili'],
            ['STATUS TEMPAT TINGGAL', 'status_tempat_tinggal'], ['NO TELPON', 'no_telpon'], ['NO. WA', 'no_wa'], ['PIHAK YANG DAPAT DIHUBUNGI SAAT DARURAT', 'kontak_darurat'],
            ['TGL. MASUK', 'tgl_masuk', 'date'], ['BULAN MASUK', 'bulan_masuk'], ['TAHUN MASUK', 'tahun_masuk'], ['STATUS', 'status_karyawan'],
            ['STATUS PPH', 'status_pph'], ['END PKWT 1', 'end_pkwt_1', 'date'], ['END PKWT 2', 'end_pkwt_2', 'date'], ['TGL. PENGANGKATAN', 'tgl_pengangkatan', 'date'],
            ['TGL SEKARANG', 'tgl_sekarang', 'date'], ['MASA KERJA DIA', 'masa_kerja'], ['USIA', 'usia'], ['NPWP', 'npwp'], ['JAMSOSTEK', 'jamsostek'],
            ['NO KPJ BPJSTK', 'no_kpj_bpjstk'], ['NO.KK', 'no_kk'], ['KTP', 'ktp'], ['ALAMAT EMAIL', 'alamat_email', 'email'],
            ['STATUS PERKAWINAN', 'status_perkawinan'], ['STATUS PERKAWINAN (EXCEL)', 'status_perkawinan_excel'], ['PENDIDIKAN', 'pendidikan'],
            ['ASAL SEKOLAH', 'asal_sekolah'], ['A.R.', 'ar'], ['END', 'end', 'date'], ['BULAN END', 'bulan_end'], ['STATUS (AKTIF/TIDAK AKTIF)', 'status_aktif'],
            ['ALAMAT NPWP', 'alamat_npwp'], ['ALAMAT ASAL', 'alamat_asal'], ['AGAMA', 'agama'], ['ASAL KOTA', 'asal_kota'],
            ['ALAMAT DOMISILI KECAMATAN', 'alamat_domisili_kecamatan'], ['AREA ASAL KECAMATAN', 'area_asal_kecamatan'], ['AREA ASAL', 'area_asal'],
          ];
          @endphp
          @foreach($fields as $f)
            @if($f[1] === 'dept')
              <label for="dept">{{ $f[0] }}</label>
              <x-department-select :selected="old('dept', $employee->dept)" />
              @error('dept')<div class="error">{{ $message }}</div>@enderror
            @else
              <label for="{{ $f[1] }}">{{ $f[0] }}</label>
              <input id="{{ $f[1] }}" type="{{ $f[2] ?? 'text' }}" name="{{ $f[1] }}" value="{{ old($f[1], $employee->{$f[1]}) }}">
              @error($f[1])<div class="error">{{ $message }}</div>@enderror
            @endif
          @endforeach
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
