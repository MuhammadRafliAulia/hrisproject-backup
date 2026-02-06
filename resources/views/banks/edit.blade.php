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
    p { margin:0 0 14px 0; color:#475569; font-size:14px; }
    input, textarea, select { width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px; color:#0f172a; box-sizing:border-box; font-family:inherit; }
    textarea { resize:vertical; }
    .btn { background:#003e6f; color:#fff; border:none; padding:8px 12px; border-radius:6px; font-size:14px; cursor:pointer; }
    .btn:hover { background:#002a4f; }
    .btn-danger { background:#dc2626; }
    .btn-link { background:#10b981; }
    .btn-group { margin-top:16px; }
    .question { background:#f8fafc; border:1px solid #e2e8f0; padding:16px; border-radius:6px; margin-bottom:12px; }
    .question-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
    .question-text { color:#0f172a; font-weight:500; margin-bottom:10px; }
    .option { margin-bottom:8px; font-size:13px; }
    .option label { display:flex; align-items:center; margin:0; }
    .option input[type=radio] { margin-right:6px; }
    .error { color:#dc2626; font-size:12px; margin-top:4px; }
    .success { background:#d1fae5; color:#065f46; padding:12px; border-radius:6px; margin-bottom:16px; font-size:13px; }
    label { display:block; font-size:13px; color:#334155; margin-bottom:6px; margin-top:12px; }
    .form-group { margin-bottom:16px; }
    .back-link { color:#0f172a; text-decoration:none; font-size:14px; }
    .back-link:hover { text-decoration:underline; }
  </style>
</head>
<body>
  <div class="container">
    <a href="{{ route('banks.index') }}" class="back-link">&larr; Kembali</a>

    <div class="card">
      <h1>{{ $bank->title }}</h1>
      @if(session('success'))
        <div class="success">{{ session('success') }}</div>
      @endif
      @if(session('link'))
        <div class="success">📋 Link Peserta: <strong>{{ session('link') }}</strong></div>
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
        <button type="submit" class="btn">Simpan</button>
      </form>
    </div>

    <div class="card">
      <h2>Soal ({{ $questions->count() }})</h2>
      @if($questions->count() > 0)
        @foreach($questions as $question)
          <div class="question">
            <div class="question-header">
              <div>
                <div class="question-text">{{ $question->order + 1 }}. {{ Str::limit($question->question, 60) }}</div>
                <div style="font-size:12px; color:#64748b; margin-top:6px;">
                  @if($question->type === 'text')
                    📝 Isian
                  @else
                    ⭕ Pilihan Ganda
                  @endif
                  @if($question->image) · 📷 Ada gambar @endif
                  @if($question->audio) · 🔊 Ada audio @endif
                </div>
              </div>
              <div style="display:flex; gap:8px;">
                <a href="{{ route('questions.edit', $question) }}" class="btn" style="background:#0ea5ad; padding:6px 10px; font-size:12px;">✏️ Edit</a>
                <form method="POST" action="{{ route('questions.delete', $question) }}" style="display:inline;" onsubmit="return confirm('Hapus soal ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" style="padding:6px 10px; font-size:12px;">🗑️ Hapus</button>
                </form>
              </div>
            </div>
            @if($question->type === 'text')
              <div style="margin-top:8px; font-size:12px; color:#334155; background:#f1f5f9; padding:8px; border-radius:4px;">
                <strong>Jawaban Benar:</strong> {{ $question->correct_answer_text }}
              </div>
            @else
              <div style="margin-top:8px; font-size:12px;">
                <div class="option"><strong>A.</strong> {{ Str::limit($question->option_a, 50) }}</div>
                <div class="option"><strong>B.</strong> {{ Str::limit($question->option_b, 50) }}</div>
                <div class="option"><strong>C.</strong> {{ Str::limit($question->option_c, 50) }}</div>
                <div class="option"><strong>D.</strong> {{ Str::limit($question->option_d, 50) }}</div>
                <div style="background:#f1f5f9; padding:8px; border-radius:4px; margin-top:6px; color:#334155;">
                  <strong>Jawaban Benar:</strong> <strong style="color:#003e6f;">{{ $question->correct_answer }}</strong>
                </div>
              </div>
            @endif
          </div>
        @endforeach
      @else
        <p style="color:#94a3b8;">Belum ada soal. Tambah soal untuk memulai.</p>
      @endif
    </div>

    <div class="card">
      <h2>Tambah Soal Baru</h2>
      <form method="POST" action="{{ route('banks.store') }}" id="addQuestionForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="bank_id" value="{{ $bank->id }}">
        
        <div class="form-group">
          <label for="type">Tipe Soal</label>
          <select id="type" name="type" required style="width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px;">
            <option value="multiple_choice">Pilihan Ganda (A/B/C/D)</option>
            <option value="text">Isian Jawaban (Teks)</option>
          </select>
        </div>

        <div class="form-group">
          <label for="question">Soal</label>
          <textarea id="question" name="question" rows="3" placeholder="Masukkan soal..." required></textarea>
        </div>

        <div class="form-group">
          <label for="image">Gambar (opsional)</label>
          <input id="image" type="file" name="image" accept="image/*">
          <small style="color:#64748b;">Format: JPEG, PNG, GIF. Max: 2MB</small>
        </div>

        <div class="form-group">
          <label for="audio">Audio (opsional)</label>
          <input id="audio" type="file" name="audio" accept="audio/*">
          <small style="color:#64748b;">Format: MP3, WAV, OGG. Max: 5MB</small>
        </div>

        <!-- Multiple Choice Options (shown by default) -->
        <div id="multipleChoiceOptions">
          <div class="form-group">
            <label for="option_a">Opsi A</label>
            <input id="option_a" type="text" name="option_a" placeholder="Opsi A...">
          </div>

          <div class="form-group">
            <label for="option_b">Opsi B</label>
            <input id="option_b" type="text" name="option_b" placeholder="Opsi B...">
          </div>

          <div class="form-group">
            <label for="option_c">Opsi C</label>
            <input id="option_c" type="text" name="option_c" placeholder="Opsi C...">
          </div>

          <div class="form-group">
            <label for="option_d">Opsi D</label>
            <input id="option_d" type="text" name="option_d" placeholder="Opsi D...">
          </div>

          <div class="form-group">
            <label for="correct_answer">Jawaban Benar</label>
            <select id="correct_answer" name="correct_answer" style="width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px;">
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
            </select>
          </div>
        </div>

        <!-- Text Answer (hidden by default) -->
        <div id="textAnswerOption" style="display:none;">
          <div class="form-group">
            <label for="correct_answer_text">Jawaban Benar</label>
            <input id="correct_answer_text" type="text" name="correct_answer_text" placeholder="Masukkan jawaban yang benar...">
          </div>
        </div>

        <button type="submit" class="btn">+ Tambah Soal</button>
      </form>

      <script>
        const typeSelect = document.getElementById('type');
        const multipleChoiceOptions = document.getElementById('multipleChoiceOptions');
        const textAnswerOption = document.getElementById('textAnswerOption');
        const optionInputs = document.querySelectorAll('#option_a, #option_b, #option_c, #option_d, #correct_answer');
        const textAnswerInput = document.getElementById('correct_answer_text');

        typeSelect.addEventListener('change', function() {
          if (this.value === 'text') {
            multipleChoiceOptions.style.display = 'none';
            textAnswerOption.style.display = 'block';
            optionInputs.forEach(input => input.removeAttribute('required'));
            textAnswerInput.setAttribute('required', 'required');
          } else {
            multipleChoiceOptions.style.display = 'block';
            textAnswerOption.style.display = 'none';
            optionInputs.forEach(input => input.setAttribute('required', 'required'));
            textAnswerInput.removeAttribute('required');
          }
        });
      </script>
    </div>

    <div class="card">
      <h2>Generate Link Peserta</h2>
      <p>Buat link baru untuk peserta yang akan mengikuti tes.</p>
      <form method="POST" action="{{ route('banks.generate-link', $bank) }}">
        @csrf
        <button type="submit" class="btn btn-link">Generate Link</button>
      </form>
    </div>

    <div class="card" style="text-align:right;">
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
      </form>
    </div>
  </div>
</body>
</html>
