<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Departemen - HRIS</title>
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
<body style="margin:0;">
<div style="display:flex;min-height:100vh;background:#f7fafc;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial;">
    @include('layouts.sidebar')
    <div class="main" style="flex:1;display:flex;flex-direction:column;">
        <div class="topbar" style="background:#fff;border-bottom:1px solid #e2e8f0;padding:16px 24px;display:flex;align-items:center;gap:16px;">
            <button onclick="window.history.back()" style="background:#e2e8f0;border:none;color:#334155;padding:6px 16px;border-radius:6px;font-size:14px;cursor:pointer;display:inline-block;">← Back</button>
            <h1 style="margin:0;font-size:20px;color:#0f172a;">Tambah Departemen</h1>
        </div>
        <div style="flex:1;padding:24px;overflow-y:auto;">
            <div style="background:#fff;border:1px solid #e2e8f0;padding:24px;border-radius:8px;max-width:600px;">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf
                    <label for="name" style="display:block;font-size:13px;color:#334155;margin-bottom:6px;margin-top:14px;">Nama Departemen</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" style="width:100%;padding:10px 12px;border:1px solid #cbd5e1;border-radius:6px;font-size:14px;color:#0f172a;box-sizing:border-box;font-family:inherit;">
                    @error('name')
                        <div style="color:#dc2626;font-size:12px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                    <button type="submit" style="background:#003e6f;color:#fff;border:none;padding:10px 12px;border-radius:6px;font-size:14px;cursor:pointer;margin-top:20px;">Simpan</button>
                    <a href="{{ route('departments.index') }}" style="background:#64748b;color:#fff;border:none;padding:10px 12px;border-radius:6px;font-size:14px;cursor:pointer;margin-top:20px;margin-left:8px;text-decoration:none;">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
