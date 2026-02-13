<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width,initial-scale=1">
 <title>Hasil - {{ $bank->title }}</title>
 <style>
 body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; padding:0; }
 .layout { display:flex; min-height:100vh; }
 .sidebar { width:280px; min-width:280px; flex-shrink:0; }
 .main { flex:1; padding:24px; min-width:0; overflow-x:auto; }
 .header { margin-bottom:24px; }
 .header a { color:#0f172a; text-decoration:none; font-size:14px; }
 .header a:hover { text-decoration:underline; }
 h1 { font-size:22px; color:#0f172a; margin:8px 0 0 0; }
 h2 { font-size:14px; color:#64748b; margin:4px 0 0 0; font-weight:400; }
 .card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:20px; margin-bottom:16px; }
 .stats { display:flex; gap:16px; margin-bottom:20px; flex-wrap:wrap; }
 .stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:16px 20px; flex:1; min-width:140px; }
 .stat-card .number { font-size:24px; font-weight:700; color:#003e6f; }
 .stat-card .label { font-size:12px; color:#64748b; margin-top:4px; }
 table { width:100%; border-collapse:collapse; }
 th, td { padding:12px; text-align:left; border-bottom:1px solid #e2e8f0; font-size:13px; }
 th { background:#f1f5f9; color:#334155; font-weight:600; position:sticky; top:0; }
 tr:last-child td { border-bottom:none; }
 tr:hover td { background:#f8fafc; }
 .score-good { background:#d1fae5; color:#065f46; padding:3px 8px; border-radius:4px; font-size:12px; }
 .score-ok { background:#fef08a; color:#713f12; padding:3px 8px; border-radius:4px; font-size:12px; }
 .score-poor { background:#fecaca; color:#991b1b; padding:3px 8px; border-radius:4px; font-size:12px; }
 .empty { text-align:center; color:#64748b; padding:40px; }
 .btn { color:#fff; border:none; padding:8px 14px; border-radius:6px; font-size:13px; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:4px; }
 .btn-primary { background:#003e6f; }
 .btn-primary:hover { background:#002a4f; }
 .btn-pdf { background:#dc2626; }
 .btn-pdf:hover { background:#b91c1c; }
 .btn-success { background:#10b981; }
 .btn-success:hover { background:#059669; }
 .btn-warning { background:#f59e0b; }
 .btn-warning:hover { background:#d97706; }
 .actions { display:flex; gap:10px; flex-wrap:wrap; justify-content:center; margin-bottom:20px; }
 .success-msg { background:#d1fae5; color:#065f46; padding:12px; border-radius:6px; margin-bottom:16px; font-size:13px; }
 .filter-form { display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; margin-bottom:20px; background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:16px 20px; }
 .filter-form .field { display:flex; flex-direction:column; gap:4px; }
 .filter-form label { font-size:12px; color:#64748b; font-weight:600; }
 .filter-form input, .filter-form select { padding:8px 10px; border:1px solid #cbd5e1; border-radius:6px; font-size:13px; color:#0f172a; }
 .filter-form .btn-filter { background:#003e6f; color:#fff; border:none; padding:8px 16px; border-radius:6px; font-size:13px; cursor:pointer; height:fit-content; }
 .filter-form .btn-filter:hover { background:#002a4f; }
 .filter-form .btn-reset { background:#64748b; color:#fff; border:none; padding:8px 16px; border-radius:6px; font-size:13px; cursor:pointer; text-decoration:none; height:fit-content; }
 .filter-form .btn-reset:hover { background:#475569; }
 </style>
 <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body>
 <div class="layout">
 @include('layouts.sidebar')
 <div class="main">
 <div class="header">
 <a href="{{ route('banks.index') }}">&larr; Kembali ke Daftar Bank Soal</a>
 <h1>Hasil Tes</h1>
 <h2>{{ $bank->title }}</h2>
 @if(request()->hasAny(['nama', 'bulan', 'tanggal']))
 <p style="font-size:13px; color:#003e6f; margin-top:8px;">
 Filter aktif:
 @if(request('nama')) <strong>Nama:</strong> {{ request('nama') }} @endif
 @if(request('bulan')) <strong>Bulan:</strong> {{ ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][request('bulan')-1] ?? '' }} @endif
 @if(request('tanggal')) <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse(request('tanggal'))->format('d/m/Y') }} @endif
 </p>
 @endif
 </div>

 @if(session('success'))
 <div class="success-msg">✓ {{ session('success') }}</div>
 @endif

 {{-- Statistics --}}
 @php
 $completedResponses = $responses->where('completed', true);
 $totalParticipants = $completedResponses->count();
 $avgScore = $totalParticipants > 0 ? round($completedResponses->avg('score'), 1) : 0;
 $totalQ = $questions->count();
 $scoreableQ = $questions->whereNotIn('type', ['narrative', 'survey'])->count();
 $avgPct = $scoreableQ > 0 && $totalParticipants > 0 ? round(($avgScore / $scoreableQ) * 100, 1) : 0;
 @endphp
 <div class="stats">
 <div class="stat-card">
 <div class="number">{{ $totalParticipants }}</div>
 <div class="label">Total Peserta Selesai</div>
 </div>
 <div class="stat-card">
 <div class="number">{{ $scoreableQ }}</div>
 <div class="label">Soal Dinilai{{ $totalQ > $scoreableQ ? ' (+ ' . ($totalQ - $scoreableQ) . ' narasi/survei)' : '' }}</div>
 </div>
 <div class="stat-card">
 <div class="number">{{ $avgScore }}</div>
 <div class="label">Rata-rata Skor</div>
 </div>
 <div class="stat-card">
 <div class="number">{{ $avgPct }}%</div>
 <div class="label">Rata-rata Persentase</div>
 </div>
 </div>

 {{-- Filter --}}
 <form method="GET" action="{{ route('banks.results', $bank) }}" class="filter-form">
 <div class="field">
 <label>Nama Peserta</label>
 <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari nama...">
 </div>
 <div class="field">
 <label>Bulan</label>
 <select name="bulan">
 <option value="">-- Semua Bulan --</option>
 @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $namaBulan)
 <option value="{{ $i + 1 }}" {{ request('bulan') == ($i + 1) ? 'selected' : '' }}>{{ $namaBulan }}</option>
 @endforeach
 </select>
 </div>
 <div class="field">
 <label>Tanggal</label>
 <input type="date" name="tanggal" value="{{ request('tanggal') }}">
 </div>
 <button type="submit" class="btn-filter"> Filter</button>
 <a href="{{ route('banks.results', $bank) }}" class="btn-reset">Reset</a>
 </form>

 {{-- Results Table --}}
 <div class="card">
 @if($completedResponses->count() > 0)
 <div style="overflow-x:auto;">
 <table>
 <thead>
 <tr>
 <th>No</th>
 <th>Nama Peserta</th>
 <th>NIK</th>
 <th>Email</th>
 <th>No. Telp</th>
 <th>Departemen</th>
 <th>Jabatan</th>
 <th>Skor</th>
 <th>Persentase</th>
 <th>Pelanggaran</th>
 <th>Durasi</th>
 <th>Waktu Selesai</th>
 <th>Aksi</th>
 </tr>
 </thead>
 <tbody>
 @foreach($completedResponses as $index => $resp)
 @php
 $pct = $scoreableQ > 0 ? round(($resp->score / $scoreableQ) * 100, 2) : 0;
 $duration = ($resp->started_at && $resp->completed_at)
 ? $resp->started_at->diff($resp->completed_at)->format('%H:%I:%S')
 : '-';
 @endphp
 <tr>
 <td>{{ $index + 1 }}</td>
 <td><strong>{{ $resp->participant_name }}</strong></td>
 <td>{{ $resp->nik ?? '-' }}</td>
 <td>{{ $resp->participant_email ?? '-' }}</td>
 <td>{{ $resp->phone ?? '-' }}</td>
 <td>{{ $resp->department ?? '-' }}</td>
 <td>{{ $resp->position ?? '-' }}</td>
 <td><strong>{{ $resp->score }} / {{ $scoreableQ }}</strong></td>
 <td>
 @if($pct >= 70)
 <span class="score-good">{{ $pct }}%</span>
 @elseif($pct >= 50)
 <span class="score-ok">{{ $pct }}%</span>
 @else
 <span class="score-poor">{{ $pct }}%</span>
 @endif
 </td>
 <td>
 @if(($resp->violation_count ?? 0) >= 3)
 <span style="background:#dc2626;color:#fff;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:600;">{{ $resp->violation_count }}x</span>
 @elseif(($resp->violation_count ?? 0) > 0)
 <span style="background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:600;">{{ $resp->violation_count }}x</span>
 @else
 <span style="color:#94a3b8;font-size:11px;">-</span>
 @endif
 </td>
 <td>{{ $duration }}</td>
 <td>{{ $resp->completed_at ? $resp->completed_at->format('d/m/Y H:i') : '-' }}</td>
 <td>
 <a href="{{ route('banks.export-participant-pdf', [$bank, $resp]) }}" class="btn btn-pdf" title="Download PDF">
 PDF
 </a>
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
 </div>
 @else
 <div class="empty">Belum ada peserta yang menyelesaikan tes ini.</div>
 @endif
 </div>

 {{-- Actions --}}
 <div class="actions">
 @if($completedResponses->count() > 0)
 <a href="{{ route('banks.export-excel', array_merge([$bank], request()->only(['nama', 'bulan', 'tanggal']))) }}" class="btn" style="background:#059669;"> Export Excel{{ request()->hasAny(['nama', 'bulan', 'tanggal']) ? ' (Hasil Filter)' : '' }}</a>
 @endif
 @if($bank->is_active)
 <form method="POST" action="{{ route('banks.toggle', $bank) }}" style="display:inline;">
 @csrf
 <button type="submit" class="btn btn-warning"> Tutup Link Soal</button>
 </form>
 @else
 <form method="POST" action="{{ route('banks.toggle', $bank) }}" style="display:inline;">
 @csrf
 <button type="submit" class="btn btn-success"> Buka Link Soal</button>
 </form>
 @endif
 <a href="{{ route('banks.index') }}" class="btn btn-primary">Kembali ke Daftar Bank</a>
 </div>
 </div>
 </div>
</body>
</html>
