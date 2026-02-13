<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Database Karyawan</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; display:flex; height:100vh; }
    .sidebar { width:280px; min-width:280px; flex-shrink:0; background:#fff; border-right:1px solid #e2e8f0; padding:20px; box-sizing:border-box; overflow-y:auto; }
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
    .card { background:#fff; border:1px solid #e2e8f0; padding:20px; border-radius:8px; margin-bottom:20px; }
    .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .header h2 { margin:0; font-size:18px; color:#0f172a; }
    .btn { background:#003e6f; color:#fff; border:none; padding:8px 14px; border-radius:6px; font-size:14px; cursor:pointer; text-decoration:none; display:inline-block; }
    .btn-small { padding:6px 10px; font-size:12px; }
    .btn-danger { background:#dc2626; }
    .btn-success { background:#10b981; }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:12px; text-align:left; border-bottom:1px solid #e2e8f0; font-size:14px; }
    th { background:#f1f5f9; color:#334155; font-weight:600; }
    .status { padding:4px 8px; border-radius:4px; font-size:12px; }
    .status.tetap { background:#d1fae5; color:#065f46; }
    .status.kontrak { background:#fef08a; color:#713f12; }
    .empty { text-align:center; color:#64748b; padding:40px; }
    .success { background:#d1fae5; color:#065f46; padding:12px; border-radius:6px; margin-bottom:16px; font-size:13px; }
    .filter-panel { background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px 20px; margin-bottom:20px; display:none; }
    .filter-panel.show { display:block; }
    .filter-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:12px; }
    .filter-group label { display:block; font-size:12px; color:#475569; margin-bottom:4px; font-weight:600; }
    .filter-group select { width:100%; padding:7px 10px; border:1px solid #cbd5e1; border-radius:6px; font-size:13px; background:#fff; }
    .filter-toggle { background:#f1f5f9; color:#334155; border:1px solid #cbd5e1; padding:8px 14px; border-radius:6px; font-size:13px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; }
    .filter-toggle:hover { background:#e2e8f0; }
    .active-filters { display:flex; flex-wrap:wrap; gap:6px; margin-top:10px; }
    .filter-badge { background:#dbeafe; color:#1e40af; padding:4px 10px; border-radius:20px; font-size:11px; display:inline-flex; align-items:center; gap:4px; }
    .filter-badge a { color:#1e40af; text-decoration:none; font-weight:bold; font-size:13px; }
    .table-wrapper { overflow-x:auto; }
  </style>
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body>
  @include('layouts.sidebar')
  <div class="main">
    <div class="topbar">
      <h1>Database Karyawan</h1>
    </div>
    <div class="content">
        <div style="display:flex;gap:10px;align-items:center;margin-bottom:18px;flex-wrap:wrap;">
          <a href="{{ route('employees.create') }}" class="btn" style="background:#003e6f;">+ Tambah Karyawan</a>
          <a href="{{ route('employees.export') }}" class="btn" style="background:#10b981;">📥 Export Excel</a>
          <a href="{{ route('employees.import-form') }}" class="btn" style="background:#3b82f6;">📤 Import Excel</a>
          <a href="{{ route('employees.template') }}" class="btn" style="background:#f59e0b;color:#fff;">📄 Download Template</a>
        </div>
      @if(session('success'))
        <div class="success">{{ session('success') }}</div>
      @endif
      <form method="GET" action="" id="filterForm">
        <div style="display:flex;gap:12px;align-items:center;margin-bottom:12px;flex-wrap:wrap;">
          <input type="text" name="q" value="{{ request('q') }}" placeholder="🔍 Cari Nama/NIK/Jabatan/No.Telp/Email..." style="padding:8px 12px;border:1px solid #cbd5e1;border-radius:6px;font-size:14px;min-width:300px;">
          <button type="submit" class="btn" style="background:#003e6f;">Cari</button>
          <button type="button" class="filter-toggle" onclick="toggleFilter()">
            🔽 Filter Kolom
            @php
              $activeCount = 0;
              foreach(['dept','gol','jabatan','seksi','gol_darah','status_karyawan','status_aktif','status_perkawinan','pendidikan','agama','asal_kota','status_pph','status_tempat_tinggal'] as $f) {
                if(request($f)) $activeCount++;
              }
            @endphp
            @if($activeCount > 0)
              <span style="background:#003e6f;color:#fff;padding:2px 7px;border-radius:10px;font-size:11px;">{{ $activeCount }}</span>
            @endif
          </button>
          @if(request('q') || $activeCount > 0)
            <a href="{{ route('employees.index') }}" class="btn" style="background:#64748b;">Reset Semua</a>
          @endif
        </div>

        <div class="filter-panel {{ $activeCount > 0 ? 'show' : '' }}" id="filterPanel">
          <div class="filter-grid">
            @php
              $filterLabels = [
                'dept' => 'Departemen',
                'gol' => 'Golongan',
                'jabatan' => 'Jabatan',
                'seksi' => 'Seksi',
                'gol_darah' => 'Gol. Darah',
                'status_karyawan' => 'Status Karyawan',
                'status_aktif' => 'Status Aktif',
                'status_perkawinan' => 'Status Perkawinan',
                'pendidikan' => 'Pendidikan',
                'agama' => 'Agama',
                'asal_kota' => 'Asal Kota',
                'status_pph' => 'Status PPH',
                'status_tempat_tinggal' => 'Status Tempat Tinggal',
              ];
            @endphp
            @foreach($filterLabels as $key => $label)
              <div class="filter-group">
                <label>{{ $label }}</label>
                <select name="{{ $key }}" onchange="document.getElementById('filterForm').submit()">
                  <option value="">-- Semua --</option>
                  @foreach($filterOptions[$key] ?? [] as $opt)
                    <option value="{{ $opt }}" {{ request($key) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                  @endforeach
                </select>
              </div>
            @endforeach
          </div>
        </div>

        @if($activeCount > 0)
        <div class="active-filters">
          <span style="font-size:12px;color:#475569;padding:4px 0;">Filter aktif:</span>
          @foreach($filterLabels as $key => $label)
            @if(request($key))
              <span class="filter-badge">
                {{ $label }}: {{ request($key) }}
                <a href="{{ request()->fullUrlWithQuery([$key => null]) }}" title="Hapus filter">&times;</a>
              </span>
            @endif
          @endforeach
        </div>
        @endif
      </form>
      <div class="card">
        <div style="margin-bottom:10px;font-size:13px;color:#475569;">Total: <strong>{{ $employees->count() }}</strong> karyawan</div>
        <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th>NIK</th>
              <th>NAMA</th>
              <th>GOL</th>
              <th>DEPT</th>
              <th>JABATAN</th>
              <th>SEKSI</th>
              <th>GOL DARAH</th>
              <th>STATUS TETAP/KONTRAK</th>
              <th>STATUS AKTIF/TIDAK AKTIF</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($employees as $employee)
            <tr>
              <td>{{ $employee->nik }}</td>
              <td>{{ $employee->nama }}</td>
              <td>{{ $employee->gol }}</td>
              <td>{{ $employee->dept }}</td>
              <td>{{ $employee->jabatan }}</td>
              <td>{{ $employee->seksi }}</td>
              <td>{{ $employee->gol_darah }}</td>
              <td>{{ ucfirst($employee->status_karyawan) }}</td>
              <td>{{ strtoupper($employee->status_aktif) }}</td>
              <td>
                <a href="{{ route('families.index', $employee) }}" class="btn btn-small" style="background:#10b981;">Data Keluarga</a>
                <a href="{{ route('employees.show', $employee) }}" class="btn btn-small" style="background:#64748b;">Detail</a>
                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-small" style="background:#3b82f6;">Edit</a>
                <form method="POST" action="{{ route('employees.destroy', $employee) }}" style="display:inline;">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-small btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="10" class="empty">{{ request()->has('q') || $activeCount > 0 ? 'Tidak ada karyawan yang cocok dengan filter.' : 'Belum ada karyawan. Tambahkan karyawan baru atau import dari file CSV.' }}</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        </div>
      </div>
      <script>
        function toggleFilter() {
          var panel = document.getElementById('filterPanel');
          panel.classList.toggle('show');
        }
      </script>
      <div style="text-align:center; color:#64748b; font-size:12px; margin-top:20px;">
        copyright @2026 Shindengen HR Internal Team
      </div>
    </div>
  </div>
</body>
</html>
