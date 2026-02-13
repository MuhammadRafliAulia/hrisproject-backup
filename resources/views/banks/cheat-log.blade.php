<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width,initial-scale=1">
 <title>Log Kecurangan Peserta</title>
 <style>
 body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; padding:0; }
 .layout { display:flex; min-height:100vh; }
 .main { flex:1; padding:24px; }
 .sidebar { width:260px; min-width:260px; flex-shrink:0; }
 .header { margin-bottom:24px; }
 .header a { color:#0f172a; text-decoration:none; font-size:14px; }
 .header a:hover { text-decoration:underline; }
 h1 { font-size:22px; color:#0f172a; margin:8px 0 4px 0; }
 h2 { font-size:14px; color:#64748b; margin:0; font-weight:400; }
 .card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:20px; margin-bottom:16px; }
 .stats { display:flex; gap:16px; margin-bottom:20px; flex-wrap:wrap; }
 .stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:16px 20px; flex:1; min-width:140px; }
 .stat-card .number { font-size:24px; font-weight:700; }
 .stat-card .label { font-size:12px; color:#64748b; margin-top:4px; }
 .stat-danger .number { color:#dc2626; }
 .stat-warning .number { color:#f59e0b; }
 .stat-info .number { color:#003e6f; }
 table { width:100%; border-collapse:collapse; }
 th, td { padding:12px; text-align:left; border-bottom:1px solid #e2e8f0; font-size:13px; }
 th { background:#f1f5f9; color:#334155; font-weight:600; position:sticky; top:0; }
 tr:hover td { background:#f8fafc; }
 .badge-danger { background:#fee2e2; color:#991b1b; padding:3px 10px; border-radius:12px; font-size:11px; font-weight:600; display:inline-block; }
 .badge-warning { background:#fef3c7; color:#92400e; padding:3px 10px; border-radius:12px; font-size:11px; font-weight:600; display:inline-block; }
 .badge-critical { background:#dc2626; color:#fff; padding:3px 10px; border-radius:12px; font-size:11px; font-weight:600; display:inline-block; }
 .empty { text-align:center; color:#64748b; padding:40px; }
 .filter-form { display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; margin-bottom:20px; background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:16px 20px; }
 .filter-form .field { display:flex; flex-direction:column; gap:4px; }
 .filter-form label { font-size:12px; color:#64748b; font-weight:600; }
 .filter-form input, .filter-form select { padding:8px 10px; border:1px solid #cbd5e1; border-radius:6px; font-size:13px; color:#0f172a; }
 .btn-filter { background:#003e6f; color:#fff; border:none; padding:8px 16px; border-radius:6px; font-size:13px; cursor:pointer; height:fit-content; }
 .btn-filter:hover { background:#002a4f; }
 .btn-reset { background:#64748b; color:#fff; border:none; padding:8px 16px; border-radius:6px; font-size:13px; cursor:pointer; text-decoration:none; height:fit-content; display:inline-block; }
 .btn-reset:hover { background:#475569; }
 .detail-btn { background:#003e6f; color:#fff; border:none; padding:4px 10px; border-radius:4px; font-size:11px; cursor:pointer; }
 .detail-btn:hover { background:#002a4f; }

 /* Modal */
 .modal-overlay { display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center; }
 .modal-overlay.show { display:flex; }
 .modal { background:#fff; border-radius:12px; max-width:600px; width:90%; max-height:80vh; overflow-y:auto; padding:24px; }
 .modal h3 { font-size:16px; color:#0f172a; margin:0 0 4px 0; }
 .modal .meta { font-size:12px; color:#64748b; margin-bottom:16px; }
 .modal .close-btn { float:right; background:none; border:none; font-size:20px; cursor:pointer; color:#64748b; padding:0 4px; }
 .modal .close-btn:hover { color:#0f172a; }
 .timeline { border-left:2px solid #e2e8f0; padding-left:16px; margin:0; }
 .timeline-item { margin-bottom:12px; position:relative; }
 .timeline-item::before { content:''; position:absolute; left:-21px; top:4px; width:10px; height:10px; border-radius:50%; background:#dc2626; border:2px solid #fff; }
 .timeline-item .tl-time { font-size:11px; color:#94a3b8; }
 .timeline-item .tl-reason { font-size:13px; color:#0f172a; margin-top:2px; }
 .note-box { background:#fef2f2; border:1px solid #fecaca; border-radius:6px; padding:10px 14px; font-size:12px; color:#991b1b; margin-top:12px; }
 </style>
 <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body>
 <div class="layout">
 @include('layouts.sidebar')
 <div class="main">
 <div class="header">
 <a href="{{ route('banks.index') }}">&larr; Kembali ke Daftar Bank Soal</a>
 <h1>Log Kecurangan Peserta</h1>
 <h2>Monitoring pelanggaran anti-cheat saat ujian psikotest</h2>
 </div>

 @php
 $totalViolators = $violations->count();
 $autoTerminated = $violations->where('violation_count', '>=', 3)->count();
 $totalViolationEvents = $violations->sum('violation_count');
 @endphp
 <div class="stats">
 <div class="stat-card stat-danger">
 <div class="number">{{ $totalViolators }}</div>
 <div class="label">Peserta Melanggar</div>
 </div>
 <div class="stat-card stat-warning">
 <div class="number">{{ $totalViolationEvents }}</div>
 <div class="label">Total Pelanggaran</div>
 </div>
 <div class="stat-card stat-danger">
 <div class="number">{{ $autoTerminated }}</div>
 <div class="label">Ujian Dihentikan Otomatis</div>
 </div>
 </div>

 {{-- Filter --}}
 <form method="GET" action="{{ route('banks.cheat-log') }}" class="filter-form">
 <div class="field">
 <label>Nama Peserta</label>
 <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari nama...">
 </div>
 <div class="field">
 <label>Bank Soal</label>
 <select name="bank_id">
 <option value="">-- Semua Bank --</option>
 @foreach($banks as $bank)
 <option value="{{ $bank->id }}" {{ request('bank_id') == $bank->id ? 'selected' : '' }}>{{ $bank->title }}</option>
 @endforeach
 </select>
 </div>
 <div class="field">
 <label>Bulan</label>
 <select name="bulan">
 <option value="">-- Semua --</option>
 @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $namaBulan)
 <option value="{{ $i + 1 }}" {{ request('bulan') == ($i + 1) ? 'selected' : '' }}>{{ $namaBulan }}</option>
 @endforeach
 </select>
 </div>
 <div class="field">
 <label>Tanggal</label>
 <input type="date" name="tanggal" value="{{ request('tanggal') }}">
 </div>
 <button type="submit" class="btn-filter">Filter</button>
 <a href="{{ route('banks.cheat-log') }}" class="btn-reset">Reset</a>
 </form>

 {{-- Results Table --}}
 <div class="card">
 @if($violations->count() > 0)
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
 <th>Bank Soal</th>
 <th>Pelanggaran</th>
 <th>Status</th>
 <th>Waktu Selesai</th>
 <th>Detail</th>
 </tr>
 </thead>
 <tbody>
 @foreach($violations as $index => $v)
 <tr>
 <td>{{ $index + 1 }}</td>
 <td><strong>{{ $v->participant_name }}</strong></td>
 <td>{{ $v->nik ?? '-' }}</td>
 <td>{{ $v->participant_email ?? '-' }}</td>
 <td>{{ $v->phone ?? '-' }}</td>
 <td>{{ $v->department ?? '-' }}</td>
 <td>{{ $v->bank->title ?? '-' }}</td>
 <td>
 @if($v->violation_count >= 3)
 <span class="badge-critical">{{ $v->violation_count }}x</span>
 @elseif($v->violation_count >= 2)
 <span class="badge-danger">{{ $v->violation_count }}x</span>
 @else
 <span class="badge-warning">{{ $v->violation_count }}x</span>
 @endif
 </td>
 <td>
 @if($v->violation_count >= 3)
 <span style="color:#dc2626;font-weight:600;font-size:12px;">Dihentikan</span>
 @else
 <span style="color:#f59e0b;font-weight:600;font-size:12px;">Peringatan</span>
 @endif
 </td>
 <td>{{ $v->completed_at ? $v->completed_at->format('d/m/Y H:i') : '-' }}</td>
 <td>
 <button class="detail-btn" onclick="showDetail({{ $index }})">Lihat</button>
 </td>
 </tr>
 @endforeach
 </tbody>
 </table>
 </div>
 @else
 <div class="empty">
 <p style="font-size:16px;margin-bottom:8px;">Tidak ada peserta yang melakukan kecurangan.</p>
 <p style="font-size:13px;">Semua peserta mengerjakan ujian dengan baik.</p>
 </div>
 @endif
 </div>
 </div>
 </div>

 {{-- Detail Modal --}}
 <div class="modal-overlay" id="detailModal">
 <div class="modal">
 <button class="close-btn" onclick="closeModal()">&times;</button>
 <h3 id="modalName"></h3>
 <div class="meta" id="modalMeta"></div>
 <div id="modalContent"></div>
 </div>
 </div>

 <script>
 @php
 $violationJsonData = $violations->map(function($v) {
 return [
 'name' => $v->participant_name,
 'nik' => $v->nik ?? '-',
 'department' => $v->department ?? '-',
 'position' => $v->position ?? '-',
 'bank' => $v->bank->title ?? '-',
 'violation_count' => $v->violation_count,
 'violation_log' => $v->violation_log ?? [],
 'anti_cheat_note' => $v->anti_cheat_note,
 'completed_at' => $v->completed_at ? $v->completed_at->format('d/m/Y H:i:s') : '-',
 'score' => $v->score,
 ];
 })->values();
 @endphp
 var violationData = @json($violationJsonData);

 function showDetail(index) {
 var d = violationData[index];
 document.getElementById('modalName').textContent = d.name;
 document.getElementById('modalMeta').innerHTML =
 'NIK: ' + d.nik + ' &middot; Email: ' + d.email + ' &middot; Telp: ' + d.phone +
 '<br>' + d.department + ' &middot; ' + d.position + ' &middot; ' + d.bank +
 '<br>Skor: <strong>' + d.score + '</strong> &middot; Selesai: ' + d.completed_at;

 var html = '<h4 style="font-size:14px;color:#334155;margin:0 0 12px 0;">Riwayat Pelanggaran (' + d.violation_count + 'x)</h4>';

 if (d.violation_log && d.violation_log.length > 0) {
 html += '<div class="timeline">';
 d.violation_log.forEach(function(log) {
 var time = log.time ? new Date(log.time).toLocaleTimeString('id-ID') : '-';
 html += '<div class="timeline-item">';
 html += '<div class="tl-time">Pelanggaran ke-' + log.count + ' &middot; ' + time + '</div>';
 html += '<div class="tl-reason">' + escapeHtml(log.type) + '</div>';
 html += '</div>';
 });
 html += '</div>';
 } else {
 html += '<p style="font-size:13px;color:#64748b;">Detail log tidak tersedia (peserta sebelum fitur ini aktif).</p>';
 }

 if (d.anti_cheat_note) {
 html += '<div class="note-box"><strong>Catatan:</strong> ' + escapeHtml(d.anti_cheat_note) + '</div>';
 }

 document.getElementById('modalContent').innerHTML = html;
 document.getElementById('detailModal').classList.add('show');
 }

 function closeModal() {
 document.getElementById('detailModal').classList.remove('show');
 }

 document.getElementById('detailModal').addEventListener('click', function(e) {
 if (e.target === this) closeModal();
 });

 function escapeHtml(text) {
 var div = document.createElement('div');
 div.textContent = text;
 return div.innerHTML;
 }
 </script>
</body>
</html>
