<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; display:flex; align-items:center; justify-content:center; height:100vh; }
    .card { background:#fff; border:1px solid #e2e8f0; padding:28px; width:360px; border-radius:8px; box-shadow:0 1px 3px rgba(16,24,40,0.04); }
    h1 { font-size:20px; margin:0 0 18px 0; color:#0f172a; text-align:center; }
    label { display:block; font-size:13px; color:#334155; margin-bottom:6px; }
    input[type=text], input[type=password] { width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px; color:#0f172a; box-sizing:border-box; }
    .btn { margin-top:14px; width:100%; background:#003e6f; color:#fff; border:none; padding:10px 12px; border-radius:6px; font-size:15px; cursor:pointer; }
    .btn:hover { background:#002a4f; }
    .muted { font-size:12px; color:#94a3b8; text-align:center; margin-top:12px; }
    .copyright { font-size:9px; color:#64748b; text-align:center; margin-top:-35px; }
    .logo-wrap { text-align:center; margin-top:-15px; }
    .logo-wrap img { height:100px; opacity:1; }
    .error { color:#dc2626; font-size:13px; margin-top:8px; }
    form > div { margin-bottom:12px; }
  </style>
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body>
  <div class="card">
    <h1>Masuk</h1>
    <form method="POST" action="{{ route('login.post') }}" autocomplete="off">
      @csrf
      <div>
        <label for="email">Email / Username</label>
        <input id="email" type="text" name="email" value="{{ old('email') }}" placeholder="Masukkan email atau username" required autocomplete="off">
        @error('email')<div class="error">{{ $message }}</div>@enderror
      </div>
      <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="Masukkan password" required autocomplete="new-password">
        @error('password')<div class="error">{{ $message }}</div>@enderror
      </div>
      <button type="submit" class="btn">Masuk</button>
    </form>
    <div class="logo-wrap">
      <img src="{{ asset('logo.png') }}" alt="Logo">
    </div>
    <div class="copyright">copyright @2026 Shindengen HR Internal Team</div>
  </div>
</body>
</html>
