<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width,initial-scale=1">
 <title>Edit Bank Soal - {{ $bank->title }}</title>
 <style>
 body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; padding:20px; }
 .container { max-width:900px; margin:0 auto; }
 .card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:20px; margin-bottom:20px; }
 h1 { font-size:20px; color:#0f172a; margin:0 0 12px 0; }
 h2 { font-size:16px; color:#334155; margin:18px 0 12px 0; }
 input, textarea, select { width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px; color:#0f172a; box-sizing:border-box; font-family:inherit; }
 textarea { resize:vertical; }
 .btn { background:#003e6f; color:#fff; border:none; padding:8px 12px; border-radius:6px; font-size:14px; cursor:pointer; text-decoration:none; display:inline-block; }
 .btn:hover { background:#002a4f; }
 .btn-danger { background:#dc2626; }
 .btn-danger:hover { background:#b91c1c; }
 .btn-link { background:#10b981; }
 .btn-link:hover { background:#059669; }
 .error { color:#dc2626; font-size:12px; margin-top:4px; }
 .success { background:#d1fae5; color:#065f46; padding:12px; border-radius:6px; margin-bottom:16px; font-size:13px; }
 label { display:block; font-size:13px; color:#334155; margin-bottom:6px; margin-top:12px; }
 .form-group { margin-bottom:16px; }
 .back-link { color:#0f172a; text-decoration:none; font-size:14px; }
 .back-link:hover { text-decoration:underline; }
 .subtest-card { background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px; margin-bottom:12px; transition:box-shadow 0.15s; }
 .subtest-card:hover { box-shadow:0 2px 8px rgba(0,0,0,0.06); }
 .subtest-header { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; }
 .subtest-title { font-size:16px; font-weight:600; color:#0f172a; }
 .subtest-meta { font-size:12px; color:#64748b; margin-top:4px; }
 .subtest-actions { display:flex; gap:8px; flex-wrap:wrap; }
 .badge { display:inline-block; font-size:11px; padding:3px 8px; border-radius:12px; font-weight:600; }
 .badge-blue { background:#dbeafe; color:#1e40af; }
 .badge-green { background:#d1fae5; color:#065f46; }
 .badge-amber { background:#fef3c7; color:#92400e; }
 .empty { text-align:center; color:#94a3b8; padding:30px; font-size:14px; }
 </style>
 <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body>
 <div class="container">
 <a href="{{ route('banks.index') }}" class="back-link">&larr; Kembali</a>

 <div class="card">
 <h1>{{ $bank->title }}</h1>
 @if(session('success'))
 <div class="success">{{ session('success') }}</div>
 @endif

 <form method="POST" action="{{ route('banks.update', $bank) }}">
 @csrf @method('PUT')
 <div class="form-group">
 <label for="title">Judul</label>
 <input id="title" type="text" name="title" value="{{ $bank->title }}" required>
 @error('title')<div class="error">{{ $message }}</div>@enderror
 </div>
 <div class="form-group">
 <label for="description">Deskripsi</label>
 <textarea id="description" name="description" rows="3">{{ $bank->description }}</textarea>
 @error('description')<div class="error">{{ $message }}</div>@enderror
 </div>
 <div class="form-group">
 <label for="duration_minutes">Waktu Pengerjaan Keseluruhan (menit)</label>
 <div style="display:flex;align-items:center;gap:8px;">
 <input id="duration_minutes" type="number" name="duration_minutes" value="{{ $bank->duration_minutes }}" min="1" max="600" placeholder="Contoh: 60" style="width:180px;">
 <span style="font-size:13px;color:#64748b;">menit (kosongkan jika tanpa batas waktu global)</span>
 </div>
 @error('duration_minutes')<div class="error">{{ $message }}</div>@enderror
 </div>
 <button type="submit" class="btn">Simpan</button>
 </form>
 </div>

 <div class="card">
 <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
 <h2 style="margin:0;">Sub-Test ({{ $subTests->count() }})</h2>
 </div>

 @if($subTests->count() > 0)
 @foreach($subTests as $index => $subTest)
 <div class="subtest-card">
 <div class="subtest-header">
 <div>
 <div class="subtest-title">{{ $index + 1 }}. {{ $subTest->title }}</div>
 <div class="subtest-meta">
 @if($subTest->description) {{ Str::limit($subTest->description, 80) }} &middot; @endif
 <span class="badge badge-blue">{{ $subTest->questions_count }} Soal</span>
 <span class="badge badge-green">{{ $subTest->example_questions_count }} Contoh</span>
 @if($subTest->duration_minutes) <span class="badge badge-amber">{{ $subTest->duration_minutes }} menit</span> @endif
 </div>
 </div>
 <div class="subtest-actions">
 <a href="{{ route('sub-tests.edit', $subTest) }}" class="btn" style="background:#3b82f6;padding:6px 12px;font-size:12px;">Edit & Kelola Soal</a>
 <form method="POST" action="{{ route('sub-tests.delete', $subTest) }}" style="display:inline;" onsubmit="return confirm('Hapus sub-test ini beserta semua soalnya?');">
 @csrf @method('DELETE')
 <button type="submit" class="btn btn-danger" style="padding:6px 12px;font-size:12px;">Hapus</button>
 </form>
 </div>
 </div>
 </div>
 @endforeach
 @else
 <div class="empty">Belum ada sub-test. Tambahkan sub-test di bawah untuk memulai.</div>
 @endif
 </div>

 <div class="card">
 <h2>Tambah Sub-Test Baru</h2>
 <form method="POST" action="{{ route('banks.store') }}">
 @csrf
 <input type="hidden" name="bank_id" value="{{ $bank->id }}">
 <div class="form-group">
 <label for="sub_test_title">Judul Sub-Test *</label>
 <input id="sub_test_title" type="text" name="sub_test_title" placeholder="Contoh: Tes Logika, Tes Verbal, dll..." required>
 @error('sub_test_title')<div class="error">{{ $message }}</div>@enderror
 </div>
 <div class="form-group">
 <label for="sub_test_description">Deskripsi (opsional)</label>
 <textarea id="sub_test_description" name="sub_test_description" rows="2" placeholder="Instruksi atau penjelasan sub-test..."></textarea>
 </div>
 <div class="form-group">
 <label for="sub_test_duration">Durasi Sub-Test (menit)</label>
 <div style="display:flex;align-items:center;gap:8px;">
 <input id="sub_test_duration" type="number" name="sub_test_duration" min="1" max="600" placeholder="Contoh: 15" style="width:180px;">
 <span style="font-size:13px;color:#64748b;">menit (kosongkan jika tanpa batas waktu)</span>
 </div>
 </div>
 <button type="submit" class="btn">+ Tambah Sub-Test</button>
 </form>
 </div>

 <div class="card">
 <h2>Link Akses Tes</h2>
 <p style="font-size:13px;color:#64748b;margin-bottom:16px;">Bagikan link ini ke semua peserta. Satu link untuk semua sub-test.</p>
 <div style="display:flex;align-items:center;gap:8px;">
 <input type="text" id="sharedLink" value="{{ route('test.register', $bank->slug) }}" readonly style="flex:1;padding:10px 12px;border:2px solid #e2e8f0;border-radius:8px;font-size:13px;background:#f8fafc;color:#0f172a;font-family:monospace;">
 <button onclick="copyLink()" type="button" class="btn btn-link" id="copyBtn" style="white-space:nowrap;">Copy Link</button>
 </div>
 <div style="margin-top:12px;background:#dbeafe;color:#0c4a6e;padding:10px 14px;border-radius:6px;font-size:12px;">
 <strong>Satu link untuk semua sub-test.</strong> Peserta akan mengerjakan tiap sub-test secara berurutan.
 </div>
 <script>
 function copyLink() {
 var input = document.getElementById('sharedLink');
 input.select(); document.execCommand('copy');
 var btn = document.getElementById('copyBtn');
 btn.textContent = 'Copied!';
 setTimeout(function() { btn.textContent = 'Copy Link'; }, 2000);
 }
 </script>
 </div>
 </div>
</body>
</html>
