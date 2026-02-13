<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Log Aktivitas Sistem</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; display:flex; height:100vh; }
    .main { flex:1; display:flex; flex-direction:column; }
    .topbar { background:#fff; border-bottom:1px solid #e2e8f0; padding:16px 24px; display:flex; justify-content:space-between; align-items:center; }
    .topbar h1 { margin:0; font-size:20px; color:#0f172a; }
    .content { flex:1; padding:24px; overflow-y:auto; }
    .card { background:#fff; border:1px solid #e2e8f0; padding:20px; border-radius:8px; margin-bottom:20px; }
    .btn { background:#003e6f; color:#fff; border:none; padding:8px 14px; border-radius:6px; font-size:13px; cursor:pointer; text-decoration:none; display:inline-block; }
    .btn-danger { background:#dc2626; }
    .btn-small { padding:6px 10px; font-size:12px; }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:10px 12px; text-align:left; border-bottom:1px solid #e2e8f0; font-size:13px; }
    th { background:#f1f5f9; color:#334155; font-weight:600; position:sticky; top:0; }
    .success { background:#d1fae5; color:#065f46; padding:12px; border-radius:6px; margin-bottom:16px; font-size:13px; }
    .empty { text-align:center; color:#64748b; padding:40px; }
    .badge { padding:3px 8px; border-radius:4px; font-size:11px; font-weight:600; display:inline-block; }
    .badge-login { background:#dbeafe; color:#1e40af; }
    .badge-logout { background:#e2e8f0; color:#475569; }
    .badge-create { background:#d1fae5; color:#065f46; }
    .badge-update { background:#fef08a; color:#713f12; }
    .badge-delete { background:#fecaca; color:#991b1b; }
    .badge-export { background:#e0e7ff; color:#3730a3; }
    .badge-import { background:#fce7f3; color:#9d174d; }
    .badge-sign { background:#ede9fe; color:#5b21b6; }
    .badge-view { background:#f0fdf4; color:#166534; }
    .badge-clear { background:#fef2f2; color:#991b1b; }
    .badge-toggle { background:#fff7ed; color:#9a3412; }
    .badge-generate { background:#ecfeff; color:#155e75; }
    .module-badge { padding:3px 8px; border-radius:4px; font-size:11px; font-weight:500; display:inline-block; background:#f1f5f9; color:#334155; }
    .filter-row { display:flex; gap:10px; align-items:center; flex-wrap:wrap; margin-bottom:16px; }
    .filter-row select, .filter-row input { padding:7px 10px; border:1px solid #cbd5e1; border-radius:6px; font-size:13px; font-family:inherit; }
    .filter-row select { min-width:140px; }
    .pagination { display:flex; justify-content:center; gap:4px; margin-top:16px; }
    .pagination a, .pagination span { padding:6px 12px; border:1px solid #e2e8f0; border-radius:4px; font-size:13px; text-decoration:none; color:#334155; }
    .pagination span.current { background:#003e6f; color:#fff; border-color:#003e6f; }
    .pagination a:hover { background:#f1f5f9; }
    .stats { display:flex; gap:12px; margin-bottom:16px; flex-wrap:wrap; }
    .stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:12px 16px; min-width:120px; }
    .stat-card .number { font-size:20px; font-weight:700; color:#003e6f; }
    .stat-card .label { font-size:11px; color:#64748b; margin-top:2px; }
    .ip { font-family:monospace; font-size:12px; color:#64748b; }
    .time { font-size:12px; color:#64748b; }
  </style>
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body>
  @include('layouts.sidebar')
  <div class="main">
    <div class="topbar">
      <h1>📋 Log Aktivitas Sistem</h1>
      <form method="POST" action="{{ route('activity-logs.clear') }}" onsubmit="return confirm('Yakin ingin menghapus SEMUA log aktivitas? Tindakan ini tidak dapat dibatalkan.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-small">🗑️ Hapus Semua Log</button>
      </form>
    </div>

    <div class="content">
      @if(session('success'))
        <div class="success">✅ {{ session('success') }}</div>
      @endif

      {{-- Stats --}}
      @php
        $totalLogs = \App\Models\ActivityLog::count();
        $todayLogs = \App\Models\ActivityLog::whereDate('created_at', today())->count();
      @endphp
      <div class="stats">
        <div class="stat-card">
          <div class="number">{{ $totalLogs }}</div>
          <div class="label">Total Log</div>
        </div>
        <div class="stat-card">
          <div class="number">{{ $todayLogs }}</div>
          <div class="label">Log Hari Ini</div>
        </div>
      </div>

      {{-- Filters --}}
      <form method="GET" action="{{ route('activity-logs.index') }}">
        <div class="filter-row">
          <input type="text" name="q" value="{{ request('q') }}" placeholder="🔍 Cari deskripsi / user...">
          <select name="module">
            <option value="">Semua Modul</option>
            @foreach($modules as $mod)
              <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $mod)) }}</option>
            @endforeach
          </select>
          <select name="action">
            <option value="">Semua Aksi</option>
            @foreach($actions as $act)
              <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>{{ ucfirst($act) }}</option>
            @endforeach
          </select>
          <select name="user_id">
            <option value="">Semua User</option>
            @foreach($users as $u)
              <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
            @endforeach
          </select>
          <input type="date" name="date_from" value="{{ request('date_from') }}" title="Dari tanggal">
          <input type="date" name="date_to" value="{{ request('date_to') }}" title="Sampai tanggal">
          <button type="submit" class="btn btn-small">Filter</button>
          @if(request()->hasAny(['q','module','action','user_id','date_from','date_to']))
            <a href="{{ route('activity-logs.index') }}" class="btn btn-small" style="background:#64748b;">Reset</a>
          @endif
        </div>
      </form>

      {{-- Table --}}
      <div class="card" style="padding:0;overflow:hidden;">
        <div style="overflow-x:auto;">
          <table>
            <thead>
              <tr>
                <th style="width:40px;">No</th>
                <th style="width:140px;">Waktu</th>
                <th>User</th>
                <th>Aksi</th>
                <th>Modul</th>
                <th>Deskripsi</th>
                <th>IP</th>
              </tr>
            </thead>
            <tbody>
              @forelse($logs as $idx => $log)
              <tr>
                <td>{{ $logs->firstItem() + $idx }}</td>
                <td>
                  <div style="font-size:13px;">{{ $log->created_at->format('d/m/Y') }}</div>
                  <div class="time">{{ $log->created_at->format('H:i:s') }}</div>
                </td>
                <td>
                  <strong>{{ $log->user_name ?? '-' }}</strong>
                </td>
                <td>
                  @php
                    $actionClass = 'badge-' . $log->action;
                  @endphp
                  <span class="badge {{ $actionClass }}">{{ strtoupper($log->action) }}</span>
                </td>
                <td><span class="module-badge">{{ ucfirst(str_replace('_', ' ', $log->module)) }}</span></td>
                <td style="max-width:350px;">{{ $log->description }}</td>
                <td><span class="ip">{{ $log->ip_address }}</span></td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="empty">Belum ada log aktivitas.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      {{-- Pagination --}}
      @if($logs->hasPages())
        <div class="pagination">
          @if($logs->onFirstPage())
            <span style="opacity:0.5;">&laquo;</span>
          @else
            <a href="{{ $logs->previousPageUrl() }}">&laquo;</a>
          @endif

          @foreach($logs->getUrlRange(max(1, $logs->currentPage()-2), min($logs->lastPage(), $logs->currentPage()+2)) as $page => $url)
            @if($page == $logs->currentPage())
              <span class="current">{{ $page }}</span>
            @else
              <a href="{{ $url }}">{{ $page }}</a>
            @endif
          @endforeach

          @if($logs->hasMorePages())
            <a href="{{ $logs->nextPageUrl() }}">&raquo;</a>
          @else
            <span style="opacity:0.5;">&raquo;</span>
          @endif
        </div>
      @endif

      <div style="text-align:center;color:#64748b;font-size:12px;margin-top:20px;">
        copyright &copy;2026 Shindengen HR Internal Team
      </div>
    </div>
  </div>
</body>
</html>
