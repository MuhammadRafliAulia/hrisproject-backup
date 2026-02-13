<?php

namespace App\Http\Controllers;

use App\Models\ParticipantResponse;
use App\Models\Bank;
use App\Models\SubTest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestController extends Controller
{
    /**
     * Show registration / biodata form for a bank (shared link).
     */
    public function register($slug)
    {
        $bank = Bank::where('slug', $slug)->firstOrFail();

        if (!$bank->is_active) {
            abort(403, 'Tes ini sudah ditutup oleh admin.');
        }

        $departments = \App\Models\Department::orderBy('name')->get();
        return view('test.form', compact('bank', 'slug', 'departments'));
    }

    /**
     * Submit biodata, create participant response, redirect to test.
     */
    public function start(Request $request, $slug)
    {
        $bank = Bank::where('slug', $slug)->firstOrFail();

        if (!$bank->is_active) {
            abort(403, 'Tes ini sudah ditutup oleh admin.');
        }

        $validated = $request->validate([
            'nik' => 'required|string|max:50',
            'participant_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'participant_email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Check if same NIK already started but not completed (resume)
        $existing = ParticipantResponse::where('bank_id', $bank->id)
            ->where('nik', $validated['nik'])
            ->where('completed', false)
            ->first();

        if ($existing) {
            // Resume existing session
            return redirect()->route('test.show', $existing->token);
        }

        // Create new participant response
        $token = Str::random(32);
        ParticipantResponse::create([
            'bank_id' => $bank->id,
            'nik' => $validated['nik'],
            'participant_name' => $validated['participant_name'],
            'participant_email' => $validated['participant_email'],
            'phone' => $validated['phone'],
            'department' => $validated['department'],
            'position' => $validated['position'],
            'token' => $token,
            'started_at' => now(),
        ]);

        return redirect()->route('test.show', $token);
    }

    /**
     * Show test questions page.
     */
    public function show($token)
    {
        $response = ParticipantResponse::where('token', $token)->firstOrFail();
        $bank = $response->bank;

        if (!$bank->is_active) {
            abort(403, 'Tes ini sudah ditutup oleh admin.');
        }

        // Already completed → thank you page
        if ($response->completed) {
            return redirect()->route('test.thankyou', $token);
        }

        // Check if time has expired (auto-submit)
        if ($bank->duration_minutes) {
            $deadline = $response->started_at->copy()->addMinutes($bank->duration_minutes);
            if (now()->greaterThanOrEqualTo($deadline)) {
                if (!$response->completed) {
                    $this->autoSubmit($response);
                }
                return redirect()->route('test.thankyou', $token);
            }
            $remainingSeconds = now()->diffInSeconds($deadline, false);
        } else {
            $remainingSeconds = null;
        }

        $questions = $bank->questions;

        // Load sub-tests with their questions and example questions
        $subTests = $bank->subTests()->with(['questions', 'exampleQuestions'])->get();
        $hasSubTests = $subTests->count() > 0;

        return view('test.show', compact('response', 'bank', 'questions', 'remainingSeconds', 'subTests', 'hasSubTests'));
    }

    /**
     * Submit test answers - score and save.
     */
    public function submit(Request $request, $token)
    {
        $response = ParticipantResponse::where('token', $token)->firstOrFail();

        // Prevent resubmission
        if ($response->completed) {
            return redirect()->route('test.thankyou', $token);
        }

        // Accept answers - may be empty on auto-submit
        $answers = $request->input('answers', []);

        // Get only real questions (not examples) for scoring
        $bank = $response->bank;
        $subTests = $bank->subTests;
        if ($subTests->count() > 0) {
            // Sub-test mode: only score non-example questions from sub-tests
            $questions = collect();
            foreach ($subTests as $st) {
                $questions = $questions->merge($st->questions); // questions() already filters is_example=false
            }
        } else {
            $questions = $bank->questions;
        }

        $score = 0;
        $responsesData = [];

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $responsesData[$question->id] = $userAnswer;

            // Skip scoring for narrative and survey questions (no correct answer)
            if ($question->type === 'narrative' || $question->type === 'survey') {
                continue;
            }

            if ($question->type === 'text') {
                if ($userAnswer && strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer_text))) {
                    $score++;
                }
            } else {
                if ($userAnswer === $question->correct_answer) {
                    $score++;
                }
            }
        }

        // Collect anti-cheat violation data
        $violationCount = (int) $request->input('violation_count', 0);
        $violationLog = $request->input('violation_log') ? json_decode($request->input('violation_log'), true) : [];
        $antiCheatNote = $request->input('anti_cheat_note');

        try {
            $response->update([
                'responses' => $responsesData,
                'score' => $score,
                'completed' => true,
                'completed_at' => now(),
                'violation_count' => $violationCount,
                'violation_log' => $violationLog,
                'anti_cheat_note' => $antiCheatNote,
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan hasil tes: ' . $e->getMessage());
        }

        return redirect()->route('test.thankyou', $token);
    }

    /**
     * Auto-submit when time expires (no answers provided by user).
     */
    private function autoSubmit(ParticipantResponse $response)
    {
        $bank = $response->bank;
        $subTests = $bank->subTests;
        if ($subTests->count() > 0) {
            $questions = collect();
            foreach ($subTests as $st) {
                $questions = $questions->merge($st->questions);
            }
        } else {
            $questions = $bank->questions;
        }

        $responsesData = [];
        $score = 0;

        // Fill empty answers
        foreach ($questions as $question) {
            $responsesData[$question->id] = null;
        }

        $response->update([
            'responses' => $responsesData,
            'score' => $score,
            'completed' => true,
            'completed_at' => now(),
        ]);
    }

    /**
     * Thank you page after test completion.
     */
    public function thankyou($token)
    {
        $response = ParticipantResponse::where('token', $token)->firstOrFail();

        if (!$response->completed) {
            return redirect()->route('test.show', $token);
        }

        return view('test.thankyou');
    }
}
