<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Data Keluarga - {{ $employee->nama }}</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; display:flex; height:100vh; }
        .main { flex:1; display:flex; flex-direction:column; }
        .topbar { background:#fff; border-bottom:1px solid #e2e8f0; padding:16px 24px; }
        .topbar h1 { margin:0; font-size:20px; color:#0f172a; }
        .content { flex:1; padding:24px; overflow-y:auto; }
        .card { background:#fff; border:1px solid #e2e8f0; padding:24px; border-radius:8px; max-width:700px; }
        table { width:100%; border-collapse:collapse; margin-top:16px; }
        th, td { padding:12px; text-align:left; border-bottom:1px solid #e2e8f0; font-size:14px; }
        th { background:#f1f5f9; color:#334155; font-weight:600; }
        .btn { background:#003e6f; color:#fff; border:none; padding:10px 12px; border-radius:6px; font-size:14px; cursor:pointer; text-decoration:none; margin-top:18px; display:inline-block; }
        .empty { text-align:center; color:#64748b; padding:40px; }
    </style>
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body>
    @include('layouts.sidebar')
    <div class="main">
        <div class="topbar">
            <h1>Data Keluarga - {{ $employee->nama }}</h1>
        </div>
        <div class="content">
            <div class="card">
                <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Hubungan</th>
                            <th>Tanggal Lahir</th>
                            <th>Pekerjaan</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($families as $family)
                        <tr>
                            <td>{{ $family->nama }}</td>
                            <td>{{ $family->hubungan }}</td>
                            <td>{{ $family->tanggal_lahir }}</td>
                            <td>{{ $family->pekerjaan }}</td>
                            <td>{{ $family->alamat }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="empty">Belum ada data keluarga.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
                <a href="{{ route('employees.index') }}" class="btn">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
