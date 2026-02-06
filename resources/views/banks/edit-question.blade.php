<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Soal</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; padding:20px; }
    .container { max-width:900px; margin:0 auto; }
    .header { margin-bottom:24px; }
    h1 { font-size:22px; color:#0f172a; margin:0; }
    .back-link { color:#0f172a; text-decoration:none; font-size:14px; }
    .back-link:hover { text-decoration:underline; }
    .card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:24px; margin-bottom:16px; }
    .form-group { margin-bottom:20px; }
    label { display:block; font-size:14px; font-weight:500; color:#334155; margin-bottom:8px; }
    input[type=text], input[type=email], input[type=number], textarea, select { width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px; box-sizing:border-box; font-family:inherit; }
    textarea { resize:vertical; min-height:100px; }
    .options { background:#f8fafc; padding:16px; border-radius:6px; }
    .option { margin-bottom:16px; }
    .option input { margin-bottom:8px; }
    .file-input { padding:10px 12px; }
    .btn { background:#003e6f; color:#fff; border:none; padding:10px 14px; border-radius:6px; font-size:14px; cursor:pointer; display:inline-block; margin-top:10px; margin-right:10px; }
    .btn:hover { background:#002a4f; }
    .btn:hover { background:#1e3a8a; }
    .btn-danger { background:#dc2626; }
    .btn-danger:hover { background:#b91c1c; }
    .btn-secondary { background:#64748b; }
    .btn-secondary:hover { background:#475569; }
    .error { color:#dc2626; font-size:12px; margin-top:4px; }
    .success { background:#d1fae5; color:#065f46; padding:12px; border-radius:6px; margin-bottom:16px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <a href="{{ route('banks.edit', $bank) }}" class="back-link">&larr; Kembali</a>
      <h1>Edit Soal</h1>
      <p style="color:#64748b; margin:6px 0 0 0;">{{ $bank->title }} - Soal #{{ $question->order + 1 ?? $question->id }}</p>
    </div>

    <div class="card">
      <form method="POST" action="{{ route('questions.update', $question) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="question">Pertanyaan *</label>
          <textarea id="question" name="question" required>{{ old('question', $question->question) }}</textarea>
          @error('question')<div class="error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label for="type">Tipe Soal *</label>
          <select id="type" name="type" required onchange="toggleOptions()">
            <option value="multiple_choice" {{ old('type', $question->type) === 'multiple_choice' ? 'selected' : '' }}>Pilihan Ganda</option>
            <option value="text" {{ old('type', $question->type) === 'text' ? 'selected' : '' }}>Isian (Teks)</option>
          </select>
        </div>

        <div id="mc-options" class="options" style="{{ old('type', $question->type) === 'text' ? 'display:none;' : '' }}">
          <div class="option">
            <label for="option_a">Opsi A *</label>
            <input type="text" id="option_a" name="option_a" value="{{ old('option_a', $question->option_a) }}" placeholder="Masukkan opsi A">
            @error('option_a')<div class="error">{{ $message }}</div>@enderror
          </div>
          <div class="option">
            <label for="option_b">Opsi B *</label>
            <input type="text" id="option_b" name="option_b" value="{{ old('option_b', $question->option_b) }}" placeholder="Masukkan opsi B">
            @error('option_b')<div class="error">{{ $message }}</div>@enderror
          </div>
          <div class="option">
            <label for="option_c">Opsi C *</label>
            <input type="text" id="option_c" name="option_c" value="{{ old('option_c', $question->option_c) }}" placeholder="Masukkan opsi C">
            @error('option_c')<div class="error">{{ $message }}</div>@enderror
          </div>
          <div class="option">
            <label for="option_d">Opsi D *</label>
            <input type="text" id="option_d" name="option_d" value="{{ old('option_d', $question->option_d) }}" placeholder="Masukkan opsi D">
            @error('option_d')<div class="error">{{ $message }}</div>@enderror
          </div>
          <div class="option">
            <label for="correct_answer">Jawaban Benar *</label>
            <select id="correct_answer" name="correct_answer">
              <option value="">-- Pilih Jawaban Benar --</option>
              <option value="A" {{ old('correct_answer', $question->correct_answer) === 'A' ? 'selected' : '' }}>A</option>
              <option value="B" {{ old('correct_answer', $question->correct_answer) === 'B' ? 'selected' : '' }}>B</option>
              <option value="C" {{ old('correct_answer', $question->correct_answer) === 'C' ? 'selected' : '' }}>C</option>
              <option value="D" {{ old('correct_answer', $question->correct_answer) === 'D' ? 'selected' : '' }}>D</option>
            </select>
            @error('correct_answer')<div class="error">{{ $message }}</div>@enderror
          </div>
        </div>

        <div id="text-answer" style="{{ old('type', $question->type) === 'text' ? '' : 'display:none;' }}">
          <div class="form-group">
            <label for="correct_answer_text">Jawaban Benar (Teks) *</label>
            <input type="text" id="correct_answer_text" name="correct_answer_text" value="{{ old('correct_answer_text', $question->correct_answer_text) }}" placeholder="Masukkan jawaban yang benar">
            @error('correct_answer_text')<div class="error">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="form-group">
          <label for="image">Gambar Soal</label>
          <input type="file" id="image" name="image" class="file-input" accept="image/*">
          <small style="color:#64748b;">Maksimal 2MB. Format: JPEG, PNG, JPG, GIF</small>
          @if($question->image)
            <div style="margin-top:12px;">
              <img src="{{ url('storage/' . $question->image) }}" alt="Preview" style="max-width:200px; max-height:200px; border-radius:6px;">
            </div>
          @endif
        </div>

        <div class="form-group">
          <label for="audio">Audio Soal</label>
          <input type="file" id="audio" name="audio" class="file-input" accept="audio/*">
          <small style="color:#64748b;">Maksimal 5MB. Format: MP3, WAV, OGG</small>
          @if($question->audio)
            <div style="margin-top:12px;">
              <audio controls style="max-width:100%;">
                <source src="{{ url('storage/' . $question->audio) }}" type="audio/mpeg">
              </audio>
            </div>
          @endif
        </div>

        <div>
          <button type="submit" class="btn">💾 Simpan Perubahan</button>
          <a href="{{ route('banks.edit', $bank) }}" class="btn btn-secondary">Batal</a>
          <form method="POST" action="{{ route('questions.delete', $question) }}" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">🗑️ Hapus Soal</button>
          </form>
        </div>
      </form>
    </div>
  </div>

  <script>
    function toggleOptions() {
      const type = document.getElementById('type').value;
      document.getElementById('mc-options').style.display = type === 'multiple_choice' ? 'block' : 'none';
      document.getElementById('text-answer').style.display = type === 'text' ? 'block' : 'none';
    }
  </script>
</body>
</html>
