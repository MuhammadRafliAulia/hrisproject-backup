<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tambah Karyawan</title>
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
      <h1>Tambah Karyawan</h1>
    </div>
    
    <div class="content">
      <div class="card">
        <h2>Data Karyawan Baru</h2>
        <form method="POST" action="{{ route('employees.store') }}">
          @csrf

          <label for="nik">NIK</label>
          <input id="nik" type="text" name="nik" value="{{ old('nik') }}">
          @error('nik')<div class="error">{{ $message }}</div>@enderror

          <label for="nama">NAMA</label>
          <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required>
          @error('nama')<div class="error">{{ $message }}</div>@enderror

          <label for="gol">GOL</label>
          <input id="gol" type="text" name="gol" value="{{ old('gol') }}">
          @error('gol')<div class="error">{{ $message }}</div>@enderror

          <label for="dept">DEPT</label>
          <x-department-select :selected="old('dept')" />
          @error('dept')<div class="error">{{ $message }}</div>@enderror

          <label for="jabatan">JABATAN</label>
          <input id="jabatan" type="text" name="jabatan" value="{{ old('jabatan') }}">
          @error('jabatan')<div class="error">{{ $message }}</div>@enderror

          <label for="seksi">SEKSI</label>
          <input id="seksi" type="text" name="seksi" value="{{ old('seksi') }}">
          @error('seksi')<div class="error">{{ $message }}</div>@enderror

          <label for="tempat_lahir">TEMPAT LAHIR</label>
          <input id="tempat_lahir" type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
          @error('tempat_lahir')<div class="error">{{ $message }}</div>@enderror

          <label for="tgl_lahir">TGL. LAHIR</label>
          <input id="tgl_lahir" type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}">
          @error('tgl_lahir')<div class="error">{{ $message }}</div>@enderror

          <label for="gol_darah">GOL. DARAH</label>
          <input id="gol_darah" type="text" name="gol_darah" value="{{ old('gol_darah') }}">
          @error('gol_darah')<div class="error">{{ $message }}</div>@enderror

          <label for="alamat_domisili">ALAMAT DOMISILI</label>
          <input id="alamat_domisili" type="text" name="alamat_domisili" value="{{ old('alamat_domisili') }}">
          @error('alamat_domisili')<div class="error">{{ $message }}</div>@enderror

          <label for="status_tempat_tinggal">STATUS TEMPAT TINGGAL</label>
          <input id="status_tempat_tinggal" type="text" name="status_tempat_tinggal" value="{{ old('status_tempat_tinggal') }}">
          @error('status_tempat_tinggal')<div class="error">{{ $message }}</div>@enderror

          <label for="no_telpon">NO TELPON</label>
          <input id="no_telpon" type="text" name="no_telpon" value="{{ old('no_telpon') }}">
          @error('no_telpon')<div class="error">{{ $message }}</div>@enderror

          <label for="no_wa">NO. WA</label>
          <input id="no_wa" type="text" name="no_wa" value="{{ old('no_wa') }}">
          @error('no_wa')<div class="error">{{ $message }}</div>@enderror

          <label for="kontak_darurat">PIHAK YANG DAPAT DIHUBUNGI SAAT DARURAT</label>
          <input id="kontak_darurat" type="text" name="kontak_darurat" value="{{ old('kontak_darurat') }}">
          @error('kontak_darurat')<div class="error">{{ $message }}</div>@enderror

          <label for="tgl_masuk">TGL. MASUK</label>
          <input id="tgl_masuk" type="date" name="tgl_masuk" value="{{ old('tgl_masuk') }}">
          @error('tgl_masuk')<div class="error">{{ $message }}</div>@enderror

          <label for="bulan_masuk">BULAN MASUK</label>
          <input id="bulan_masuk" type="text" name="bulan_masuk" value="{{ old('bulan_masuk') }}">
          @error('bulan_masuk')<div class="error">{{ $message }}</div>@enderror

          <label for="tahun_masuk">TAHUN MASUK</label>
          <input id="tahun_masuk" type="text" name="tahun_masuk" value="{{ old('tahun_masuk') }}">
          @error('tahun_masuk')<div class="error">{{ $message }}</div>@enderror

          <label for="status_karyawan">STATUS</label>
          <input id="status_karyawan" type="text" name="status_karyawan" value="{{ old('status_karyawan') }}">
          @error('status_karyawan')<div class="error">{{ $message }}</div>@enderror

          <label for="status_pph">STATUS PPH</label>
          <input id="status_pph" type="text" name="status_pph" value="{{ old('status_pph') }}">
          @error('status_pph')<div class="error">{{ $message }}</div>@enderror

          <label for="end_pkwt_1">END PKWT 1</label>
          <input id="end_pkwt_1" type="date" name="end_pkwt_1" value="{{ old('end_pkwt_1') }}">
          @error('end_pkwt_1')<div class="error">{{ $message }}</div>@enderror

          <label for="end_pkwt_2">END PKWT 2</label>
          <input id="end_pkwt_2" type="date" name="end_pkwt_2" value="{{ old('end_pkwt_2') }}">
          @error('end_pkwt_2')<div class="error">{{ $message }}</div>@enderror

          <label for="tgl_pengangkatan">TGL. PENGANGKATAN</label>
          <input id="tgl_pengangkatan" type="date" name="tgl_pengangkatan" value="{{ old('tgl_pengangkatan') }}">
          @error('tgl_pengangkatan')<div class="error">{{ $message }}</div>@enderror

          <label for="tgl_sekarang">TGL SEKARANG</label>
          <input id="tgl_sekarang" type="date" name="tgl_sekarang" value="{{ old('tgl_sekarang', date('Y-m-d')) }}">
          @error('tgl_sekarang')<div class="error">{{ $message }}</div>@enderror

          <label for="masa_kerja">MASA KERJA DIA</label>
          <input id="masa_kerja" type="text" name="masa_kerja" value="{{ old('masa_kerja') }}">
          @error('masa_kerja')<div class="error">{{ $message }}</div>@enderror

          <label for="usia">USIA</label>
          <input id="usia" type="text" name="usia" value="{{ old('usia') }}">
          @error('usia')<div class="error">{{ $message }}</div>@enderror

          <label for="npwp">NPWP</label>
          <input id="npwp" type="text" name="npwp" value="{{ old('npwp') }}">
          @error('npwp')<div class="error">{{ $message }}</div>@enderror

          <label for="jamsostek">JAMSOSTEK</label>
          <input id="jamsostek" type="text" name="jamsostek" value="{{ old('jamsostek') }}">
          @error('jamsostek')<div class="error">{{ $message }}</div>@enderror

          <label for="no_kpj_bpjstk">NO KPJ BPJSTK</label>
          <input id="no_kpj_bpjstk" type="text" name="no_kpj_bpjstk" value="{{ old('no_kpj_bpjstk') }}">
          @error('no_kpj_bpjstk')<div class="error">{{ $message }}</div>@enderror

          <label for="no_kk">NO.KK</label>
          <input id="no_kk" type="text" name="no_kk" value="{{ old('no_kk') }}">
          @error('no_kk')<div class="error">{{ $message }}</div>@enderror

          <label for="ktp">KTP</label>
          <input id="ktp" type="text" name="ktp" value="{{ old('ktp') }}">
          @error('ktp')<div class="error">{{ $message }}</div>@enderror

          <label for="alamat_email">ALAMAT EMAIL</label>
          <input id="alamat_email" type="email" name="alamat_email" value="{{ old('alamat_email') }}">
          @error('alamat_email')<div class="error">{{ $message }}</div>@enderror

          <label for="status_perkawinan">STATUS PERKAWINAN</label>
          <input id="status_perkawinan" type="text" name="status_perkawinan" value="{{ old('status_perkawinan') }}">
          @error('status_perkawinan')<div class="error">{{ $message }}</div>@enderror

          <label for="status_perkawinan_excel">STATUS PERKAWINAN (EXCEL)</label>
          <input id="status_perkawinan_excel" type="text" name="status_perkawinan_excel" value="{{ old('status_perkawinan_excel') }}">
          @error('status_perkawinan_excel')<div class="error">{{ $message }}</div>@enderror

          <label for="pendidikan">PENDIDIKAN</label>
          <input id="pendidikan" type="text" name="pendidikan" value="{{ old('pendidikan') }}">
          @error('pendidikan')<div class="error">{{ $message }}</div>@enderror

          <label for="asal_sekolah">ASAL SEKOLAH</label>
          <input id="asal_sekolah" type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}">
          @error('asal_sekolah')<div class="error">{{ $message }}</div>@enderror

          <label for="ar">A.R.</label>
          <input id="ar" type="text" name="ar" value="{{ old('ar') }}">
          @error('ar')<div class="error">{{ $message }}</div>@enderror

          <label for="end">END</label>
          <input id="end" type="date" name="end" value="{{ old('end') }}">
          @error('end')<div class="error">{{ $message }}</div>@enderror

          <label for="bulan_end">BULAN END</label>
          <input id="bulan_end" type="text" name="bulan_end" value="{{ old('bulan_end') }}">
          @error('bulan_end')<div class="error">{{ $message }}</div>@enderror

          <label for="status_aktif">STATUS (AKTIF/TIDAK AKTIF)</label>
          <input id="status_aktif" type="text" name="status_aktif" value="{{ old('status_aktif') }}">
          @error('status_aktif')<div class="error">{{ $message }}</div>@enderror

          <label for="alamat_npwp">ALAMAT NPWP</label>
          <input id="alamat_npwp" type="text" name="alamat_npwp" value="{{ old('alamat_npwp') }}">
          @error('alamat_npwp')<div class="error">{{ $message }}</div>@enderror

          <label for="alamat_asal">ALAMAT ASAL</label>
          <input id="alamat_asal" type="text" name="alamat_asal" value="{{ old('alamat_asal') }}">
          @error('alamat_asal')<div class="error">{{ $message }}</div>@enderror

          <label for="agama">AGAMA</label>
          <input id="agama" type="text" name="agama" value="{{ old('agama') }}">
          @error('agama')<div class="error">{{ $message }}</div>@enderror

          <label for="asal_kota">ASAL KOTA</label>
          <input id="asal_kota" type="text" name="asal_kota" value="{{ old('asal_kota') }}">
          @error('asal_kota')<div class="error">{{ $message }}</div>@enderror

          <label for="alamat_domisili_kecamatan">ALAMAT DOMISILI KECAMATAN</label>
          <input id="alamat_domisili_kecamatan" type="text" name="alamat_domisili_kecamatan" value="{{ old('alamat_domisili_kecamatan') }}">
          @error('alamat_domisili_kecamatan')<div class="error">{{ $message }}</div>@enderror

          <label for="area_asal_kecamatan">AREA ASAL KECAMATAN</label>
          <input id="area_asal_kecamatan" type="text" name="area_asal_kecamatan" value="{{ old('area_asal_kecamatan') }}">
          @error('area_asal_kecamatan')<div class="error">{{ $message }}</div>@enderror

          <label for="area_asal">AREA ASAL</label>
          <input id="area_asal" type="text" name="area_asal" value="{{ old('area_asal') }}">
          @error('area_asal')<div class="error">{{ $message }}</div>@enderror

          <div>
            <button type="submit" class="btn">Simpan</button>
            <a href="{{ route('employees.index') }}" class="btn btn-cancel" style="text-decoration:none;">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
