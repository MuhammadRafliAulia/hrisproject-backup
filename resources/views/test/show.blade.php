<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tes Psikotest</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7fafc; margin:0; padding:20px; }
    .container { max-width:800px; margin:0 auto; }
    .card { background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:24px; }
    h1 { font-size:18px; color:#0f172a; margin:0 0 20px 0; }
    .info { background:#dbeafe; color:#0c4a6e; padding:12px; border-radius:6px; margin-bottom:20px; font-size:13px; }
    form { display:flex; flex-direction:column; }
    .form-group { margin-bottom:18px; }
    label { display:block; font-size:13px; color:#334155; margin-bottom:8px; font-weight:500; }
    input[type=text], input[type=email] { width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px; color:#0f172a; box-sizing:border-box; }
    .question-section { margin-top:24px; padding-top:24px; border-top:1px solid #e2e8f0; }
    .question-text { background:#f8fafc; border-left:3px solid #003e6f; padding:16px; margin-bottom:16px; color:#0f172a; font-size:14px; }
    .options { margin-bottom:24px; }
    .option { margin-bottom:12px; }
    .option label { display:flex; align-items:center; margin:0; }
    .option input[type=radio] { margin-right:8px; cursor:pointer; }
    .option label span { cursor:pointer; }
    .btn { background:#003e6f; color:#fff; border:none; padding:10px 14px; border-radius:6px; font-size:14px; cursor:pointer; margin-top:20px; }
    .btn:hover { background:#002a4f; }
    .error { color:#dc2626; font-size:12px; margin-top:4px; }
    .question-counter { font-size:12px; color:#64748b; margin-bottom:6px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h1>{{ $bank->title }}</h1>
      <div class="info">
        ℹ️ Peserta: <strong>{{ $response->participant_name }}</strong> | Email: {{ $response->participant_email }} | Posisi: {{ $response->position }}
      </div>

      <form method="POST" action="{{ route('test.submit', $response->token) }}">
        @csrf


        @if($questions->count() > 0)
          <div class="question-section">
            @foreach($questions as $index => $question)
              <div>
                <div class="question-counter">Pertanyaan {{ $index + 1 }} dari {{ $questions->count() }}</div>
                <div class="question-text">{{ $question->question }}</div>

                @if($question->image)
                  <div style="margin:12px 0; text-align:center;">
                    <img src="{{ url('storage/' . $question->image) }}" alt="Gambar soal" style="max-width:100%; max-height:400px; border-radius:6px;">
                  </div>
                @endif

                @if($question->audio)
                  <div style="margin:12px 0;">
                    <audio controls style="width:100%; max-width:400px;">
                      <source src="{{ url('storage/' . $question->audio) }}" type="audio/mpeg">
                      Browser Anda tidak mendukung audio player.
                    </audio>
                  </div>
                @endif

                @if($question->type === 'text')
                  <!-- Text Input -->
                  <div class="form-group">
                    <input type="text" name="answers[{{ $question->id }}]" placeholder="Masukkan jawaban Anda..." required style="width:100%; padding:10px 12px; border:1px solid #cbd5e1; border-radius:6px; font-size:14px;">
                  </div>
                @else
                  <!-- Multiple Choice -->
                  <div class="options">
                    <div class="option">
                      <label>
                        <input type="radio" name="answers[{{ $question->id }}]" value="A" required>
                        <span><strong>A.</strong> {{ $question->option_a }}</span>
                      </label>
                    </div>
                    <div class="option">
                      <label>
                        <input type="radio" name="answers[{{ $question->id }}]" value="B">
                        <span><strong>B.</strong> {{ $question->option_b }}</span>
                      </label>
                    </div>
                    <div class="option">
                      <label>
                        <input type="radio" name="answers[{{ $question->id }}]" value="C">
                        <span><strong>C.</strong> {{ $question->option_c }}</span>
                      </label>
                    </div>
                    <div class="option">
                      <label>
                        <input type="radio" name="answers[{{ $question->id }}]" value="D">
                        <span><strong>D.</strong> {{ $question->option_d }}</span>
                      </label>
                    </div>
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        @else
          <p style="color:#94a3b8; text-align:center; padding:40px;">Bank soal masih kosong. Hubungi administrator.</p>
        @endif

        <button type="submit" class="btn">Selesaikan Tes</button>
      </form>

      <div style="text-align:center; margin-top:24px; font-size:12px; color:#64748b;">
        copyright @2026 Shindengen HR Internal Team
      </div>
    </div>
  </div>
</body>
</html>
