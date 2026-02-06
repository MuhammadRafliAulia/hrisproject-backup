<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Hasil - {{ $bank->title }}</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; padding:20px; }
    .container { max-width:900px; margin:0 auto; }
    .header { margin-bottom:24px; }
    h1 { font-size:22px; color:#0f172a; margin:0; }
    h2 { font-size:14px; color:#64748b; margin:6px 0 0 0; font-weight:400; }
    .back-link { color:#0f172a; text-decoration:none; font-size:14px; }
    .back-link:hover { text-decoration:underline; }
    .card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:20px; margin-bottom:16px; }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:12px; text-align:left; border-bottom:1px solid #e2e8f0; font-size:13px; }
    th { background:#f1f5f9; color:#334155; font-weight:600; }
    tr:last-child td { border-bottom:none; }
    .score-good { background:#d1fae5; color:#065f46; padding:3px 8px; border-radius:4px; font-size:12px; }
    .score-ok { background:#fef08a; color:#713f12; padding:3px 8px; border-radius:4px; font-size:12px; }
    .empty { text-align:center; color:#64748b; padding:40px; }
    .btn { background:#003e6f; color:#fff; border:none; padding:8px 14px; border-radius:6px; font-size:14px; cursor:pointer; text-decoration:none; display:inline-block; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <a href="{{ route('banks.index') }}" class="back-link">&larr; Kembali</a>
      <h1>Hasil Tes</h1>
      <h2>{{ $bank->title }}</h2>
    </div>

    <div class="card">
      @if($responses->count() > 0)
        <table>
          <thead>
            <tr>
              <th>Nama Peserta</th>
              <th>Email</th>
              <th>Skor</th>
              <th>Persentase</th>
              <th>Status</th>
              <th>Waktu Selesai</th>
            </tr>
          </thead>
          <tbody>
            @foreach($responses as $response)
              @php
                $total = $response->bank->questions->count();
                $percentage = $total > 0 ? round(($response->score / $total) * 100, 2) : 0;
              @endphp
              <tr>
                <td>{{ $response->participant_name }}</td>
                <td>{{ $response->participant_email }}</td>
                <td><strong>{{ $response->score }} / {{ $total }}</strong></td>
                <td>
                  @if($percentage >= 70)
                    <span class="score-good">{{ $percentage }}%</span>
                  @else
                    <span class="score-ok">{{ $percentage }}%</span>
                  @endif
                </td>
                <td>
                  @if($response->completed)
                    <span style="color:#065f46; font-weight:500;">✓ Selesai</span>
                  @else
                    <span style="color:#64748b; font-weight:500;">⋯ Berlangsung</span>
                  @endif
                </td>
                <td>{{ $response->completed_at ? $response->completed_at->format('d/m/Y H:i') : '-' }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="empty">Belum ada peserta yang mengikuti tes ini.</div>
      @endif
    </div>

    <div style="text-align:center; display:flex; gap:10px; justify-content:center; margin-bottom:20px;">
      @if($bank->is_active)
        <form method="POST" action="{{ route('banks.toggle', $bank) }}" style="display:inline;">
          @csrf
          <button type="submit" class="btn" style="background:#f59e0b;">🔒 Tutup Link Soal</button>
        </form>
      @else
        <form method="POST" action="{{ route('banks.toggle', $bank) }}" style="display:inline;">
          @csrf
          <button type="submit" class="btn" style="background:#10b981;">🔓 Buka Link Soal</button>
        </form>
      @endif
      <a href="{{ route('banks.export', $bank) }}" class="btn" style="background:#059669;">📥 Export CSV</a>
      <a href="{{ route('banks.export-excel', $bank) }}" class="btn" style="background:#008000;">📊 Export Excel</a>
      <a href="{{ route('banks.index') }}" class="btn">Kembali ke Daftar Bank</a>
    </div>
  </div>
</body>
</html>
