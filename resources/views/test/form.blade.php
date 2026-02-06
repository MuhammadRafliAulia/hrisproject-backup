<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Data Diri - {{ $bank->title }}</title>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { 
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .container { max-width: 500px; width: 100%; }
    .card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
      padding: 40px;
    }
    .header {
      text-align: center;
      margin-bottom: 30px;
    }
    .header h1 {
      font-size: 24px;
      color: #0f172a;
      margin-bottom: 8px;
    }
    .header p {
      color: #64748b;
      font-size: 14px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    label {
      display: block;
      font-size: 14px;
      font-weight: 500;
      color: #334155;
      margin-bottom: 8px;
    }
    input[type="text"],
    input[type="email"],
    select {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      font-size: 14px;
      transition: all 0.2s;
      font-family: inherit;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    select:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    .btn {
      width: 100%;
      padding: 11px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
    }
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }
    .error-alert {
      background: #fee;
      color: #c41e3a;
      padding: 12px;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 14px;
      border-left: 4px solid #c41e3a;
    }
    .info-text {
      font-size: 13px;
      color: #64748b;
      margin-top: 6px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="header">
        <h1>Formulir Peserta Tes</h1>
        <p>{{ $bank->title }}</p>
      </div>

      @if($errors->any())
        <div class="error-alert">
          <strong>⚠️ Pemberitahuan:</strong><br>
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('test.submit-form', $token) }}">
        @csrf

        <div class="form-group">
          <label for="participant_name">Nama Lengkap *</label>
          <input 
            type="text" 
            id="participant_name" 
            name="participant_name" 
            placeholder="Masukkan nama lengkap Anda"
            value="{{ old('participant_name') }}"
            required
            autofocus
          >
          <div class="info-text">Nama sesuai dengan identitas diri</div>
        </div>

        <div class="form-group">
          <label for="participant_email">Email *</label>
          <input 
            type="email" 
            id="participant_email" 
            name="participant_email" 
            placeholder="nama@email.com"
            value="{{ old('participant_email') }}"
            required
          >
          <div class="info-text">Email yang masih aktif dan dapat dihubungi</div>
        </div>

        <div class="form-group">
          <label for="position">Posisi Lowongan *</label>
          <select id="position" name="position" required>
            <option value="">-- Pilih Posisi Lowongan --</option>
            <option value="Manager" {{ old('position') == 'Manager' ? 'selected' : '' }}>Manager</option>
            <option value="Supervisor" {{ old('position') == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
            <option value="Staff" {{ old('position') == 'Staff' ? 'selected' : '' }}>Staff</option>
            <option value="Intern" {{ old('position') == 'Intern' ? 'selected' : '' }}>Intern</option>
          </select>
          <div class="info-text">Posisi yang Anda daftar</div>
        </div>

        <button type="submit" class="btn">Lanjutkan ke Tes</button>
      </form>
    </div>
  </div>

  @if(session('duplicate_error'))
    <script>
      setTimeout(() => {
        alert('anda sudah tidak bisa mengerjakan test ini lagi');
        window.location.href = '/';
      }, 100);
    </script>
  @endif
</body>
</html>
