<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Hasil Tes</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; padding:20px; display:flex; align-items:center; justify-content:center; min-height:100vh; }
    .card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:32px; text-align:center; max-width:500px; box-shadow:0 1px 3px rgba(16,24,40,0.04); }
    .badge { display:inline-block; width:100px; height:100px; border-radius:50%; background:#003e6f; color:#fff; display:flex; align-items:center; justify-content:center; font-size:32px; font-weight:bold; margin:0 auto 24px; }
    h1 { font-size:22px; color:#0f172a; margin:0 0 12px 0; }
    .score { font-size:18px; color:#334155; margin-bottom:12px; }
    .percentage { font-size:16px; margin-bottom:24px; }
    .percentage.good { color:#065f46; background:#d1fae5; padding:12px; border-radius:6px; }
    .percentage.ok { color:#713f12; background:#fef08a; padding:12px; border-radius:6px; }
    .percentage.poor { color:#7c2d12; background:#fed7aa; padding:12px; border-radius:6px; }
    .details { margin-top:24px; padding-top:24px; border-top:1px solid #e2e8f0; font-size:13px; color:#475569; }
    .detail-row { margin-bottom:8px; }
    .detail-label { color:#64748b; }
    .copyright { font-size:12px; color:#64748b; margin-top:24px; }
  </style>
</head>
<body>
  <div class="card">
    @php
      $percentage = $total > 0 ? round(($response->score / $total) * 100, 2) : 0;
    @endphp

    <div class="badge">{{ $response->score }}/{{ $total }}</div>
    <h1>Tes Selesai</h1>
    <p style="color:#334155; margin:0;">{{ $response->bank->title }}</p>

    <div class="percentage good" style="margin-top:20px;">
      ✓ Terima kasih telah mengikuti tes ini.
    </div>

    <div class="details">
      <div class="detail-row">
        <span class="detail-label">Nama:</span> {{ $response->participant_name }}
      </div>
      <div class="detail-row">
        <span class="detail-label">Email:</span> {{ $response->participant_email }}
      </div>
      <div class="detail-row">
        <span class="detail-label">Waktu:</span> {{ $response->completed_at->format('d/m/Y H:i:s') }}
      </div>
    </div>

    <div class="copyright">
      Terima kasih telah mengikuti tes ini.<br>
      copyright @2026 Shindengen HR Internal Team
    </div>
  </div>
</body>
</html>
