<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Question;
use App\Models\ParticipantResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $banks = Bank::where('user_id', Auth::id())->get();
        return view('banks.index', compact('banks'));
    }

    public function create()
    {
        return view('banks.create');
    }

    public function store(Request $request)
    {
        // If bank_id is provided, it's adding a question
        if ($request->has('bank_id') && $request->filled('bank_id')) {
            return $this->storeQuestion($request);
        }

        // Otherwise, create a new bank
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $bank = Bank::create(array_merge($validated, ['user_id' => Auth::id()]));
        return redirect()->route('banks.edit', $bank)->with('success', 'Bank soal berhasil dibuat.');
    }

    private function storeQuestion(Request $request)
    {
        $bank = Bank::findOrFail($request->bank_id);
        $this->authorize('update', $bank);

        $type = $request->input('type', 'multiple_choice');

        if ($type === 'text') {
            $validated = $request->validate([
                'question' => 'required|string|max:1000',
                'correct_answer_text' => 'required|string|max:500',
                'type' => 'required|in:text,multiple_choice',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'audio' => 'nullable|mimes:mp3,wav,ogg|max:5120',
            ]);

            // Handle file uploads
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('questions/images', 'public');
                $validated['image'] = $imagePath;
            }
            if ($request->hasFile('audio')) {
                $audioPath = $request->file('audio')->store('questions/audio', 'public');
                $validated['audio'] = $audioPath;
            }

            // Provide safe defaults for MC fields so DB insert won't fail if columns are non-nullable
            $validated['option_a'] = $validated['option_a'] ?? null;
            $validated['option_b'] = $validated['option_b'] ?? null;
            $validated['option_c'] = $validated['option_c'] ?? null;
            $validated['option_d'] = $validated['option_d'] ?? null;
            $validated['correct_answer'] = $validated['correct_answer'] ?? null;
        } else {
            $validated = $request->validate([
                'question' => 'required|string|max:1000',
                'option_a' => 'required|string|max:500',
                'option_b' => 'required|string|max:500',
                'option_c' => 'required|string|max:500',
                'option_d' => 'required|string|max:500',
                'correct_answer' => 'required|in:A,B,C,D',
                'type' => 'required|in:text,multiple_choice',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'audio' => 'nullable|mimes:mp3,wav,ogg|max:5120',
            ]);

            // Handle file uploads
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('questions/images', 'public');
                $validated['image'] = $imagePath;
            }
            if ($request->hasFile('audio')) {
                $audioPath = $request->file('audio')->store('questions/audio', 'public');
                $validated['audio'] = $audioPath;
            }
        }

        $order = $bank->questions()->max('order') ?? -1;
        $validated['order'] = $order + 1;
        $validated['bank_id'] = $bank->id;

        Question::create($validated);

        return redirect()->route('banks.edit', $bank)->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(Bank $bank)
    {
        $this->authorize('update', $bank);
        $questions = $bank->questions;
        // Ambil semua link peserta yang sudah digenerate
        $links = $bank->responses()->orderBy('created_at', 'desc')->get();
        return view('banks.edit', compact('bank', 'questions', 'links'));
    }

    public function update(Request $request, Bank $bank)
    {
        $this->authorize('update', $bank);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $bank->update($validated);
        return redirect()->route('banks.edit', $bank)->with('success', 'Bank soal berhasil diperbarui.');
    }

    public function destroy(Bank $bank)
    {
        $this->authorize('delete', $bank);
        $bank->delete();
        return redirect()->route('banks.index')->with('success', 'Bank soal berhasil dihapus.');
    }

    public function results(Bank $bank)
    {
        $this->authorize('view', $bank);
        $responses = $bank->responses()->orderBy('created_at', 'desc')->get();
        return view('banks.results', compact('bank', 'responses'));
    }

    public function generateLink(Bank $bank)
    {
        $this->authorize('update', $bank);
        $token = \Illuminate\Support\Str::random(32);
        $response = $bank->responses()->create([
            'participant_name' => 'Peserta',
            'participant_email' => 'participant-' . $token . '@test.local',
            'token' => $token,
            'is_active' => true,
        ]);

        $link = route('test.show', $token);
        return back()->with('success', 'Link berhasil dibuat.')->with('link', $link);
    }

    public function toggleBank(Bank $bank)
    {
        $this->authorize('update', $bank);

        $bank->update(['is_active' => !$bank->is_active]);

        $status = $bank->is_active ? 'dibuka' : 'ditutup';
        return back()->with('success', 'Link soal berhasil ' . $status . '.');
    }

    public function editQuestion(Question $question)
    {
        $bank = $question->bank;
        $this->authorize('update', $bank);
        return view('banks.edit-question', compact('bank', 'question'));
    }

    public function updateQuestion(Request $request, Question $question)
    {
        $bank = $question->bank;
        $this->authorize('update', $bank);

        $type = $request->input('type', 'multiple_choice');

        if ($type === 'text') {
            $validated = $request->validate([
                'question' => 'required|string|max:1000',
                'correct_answer_text' => 'required|string|max:500',
                'type' => 'required|in:text,multiple_choice',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'audio' => 'nullable|mimes:mp3,wav,ogg|max:5120',
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('questions/images', 'public');
                $validated['image'] = $imagePath;
            }
            if ($request->hasFile('audio')) {
                $audioPath = $request->file('audio')->store('questions/audio', 'public');
                $validated['audio'] = $audioPath;
            }

            $validated['option_a'] = null;
            $validated['option_b'] = null;
            $validated['option_c'] = null;
            $validated['option_d'] = null;
            $validated['correct_answer'] = null;
        } else {
            $validated = $request->validate([
                'question' => 'required|string|max:1000',
                'option_a' => 'required|string|max:500',
                'option_b' => 'required|string|max:500',
                'option_c' => 'required|string|max:500',
                'option_d' => 'required|string|max:500',
                'correct_answer' => 'required|in:A,B,C,D',
                'type' => 'required|in:text,multiple_choice',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'audio' => 'nullable|mimes:mp3,wav,ogg|max:5120',
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('questions/images', 'public');
                $validated['image'] = $imagePath;
            }
            if ($request->hasFile('audio')) {
                $audioPath = $request->file('audio')->store('questions/audio', 'public');
                $validated['audio'] = $audioPath;
            }
        }

        $question->update($validated);
        return redirect()->route('banks.edit', $bank)->with('success', 'Soal berhasil diperbarui.');
    }

    public function deleteQuestion(Question $question)
    {
        $bank = $question->bank;
        $this->authorize('update', $bank);
        $question->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }

    public function exportResults(Bank $bank)
    {
        $this->authorize('view', $bank);

        $responses = $bank->responses()->orderBy('created_at', 'desc')->get();
        $questions = $bank->questions()->orderBy('order')->get();

        $fileName = 'bank-' . $bank->id . '-results.csv';

        $callback = function () use ($responses, $questions) {
            $out = fopen('php://output', 'w');

            $header = ['participant_name', 'participant_email', 'score', 'completed_at'];
            foreach ($questions as $q) {
                $header[] = 'Q' . ($q->order ?? $q->id);
            }

            fputcsv($out, $header);

            foreach ($responses as $r) {
                $row = [
                    $r->participant_name,
                    $r->participant_email,
                    $r->score,
                    $r->completed_at ? $r->completed_at->toDateTimeString() : '',
                ];

                $answers = $r->responses ?? [];
                foreach ($questions as $q) {
                    $row[] = $answers[$q->id] ?? '';
                }

                fputcsv($out, $row);
            }

            fclose($out);
        };

        return response()->streamDownload($callback, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function exportExcel(Bank $bank)
    {
        $this->authorize('view', $bank);

        $responses = $bank->responses()->orderBy('created_at', 'desc')->get();
        $questions = $bank->questions()->orderBy('order')->get();

        $total = $questions->count();
        $fileName = 'bank-' . $bank->id . '-results-' . date('Y-m-d-His') . '.csv';

        $callback = function () use ($responses, $questions, $total) {
            $out = fopen('php://output', 'w');

            // Set UTF-8 BOM for proper Excel encoding
            fwrite($out, "\xEF\xBB\xBF");

            // Header row
            $header = ['Nama Peserta', 'Email', 'Skor', 'Persentase (%)', 'Status', 'Waktu Selesai'];
            foreach ($questions as $q) {
                $header[] = 'Q' . ($q->order + 1 ?? $q->id) . ': ' . substr($q->question, 0, 50);
            }

            fputcsv($out, $header, ';');

            // Data rows
            foreach ($responses as $r) {
                $percentage = $total > 0 ? round(($r->score / $total) * 100, 2) : 0;

                $row = [
                    $r->participant_name,
                    $r->participant_email,
                    $r->score,
                    $percentage,
                    $r->completed ? 'Selesai' : 'Berlangsung',
                    $r->completed_at ? $r->completed_at->format('d/m/Y H:i') : '',
                ];

                // Each question answer in separate column
                $answers = $r->responses ?? [];
                foreach ($questions as $q) {
                    $answer = $answers[$q->id] ?? '';
                    $row[] = $answer;
                }

                fputcsv($out, $row, ';');
            }

            fclose($out);
        };

        return response()->streamDownload($callback, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
