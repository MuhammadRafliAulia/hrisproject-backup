<?php

namespace App\Http\Controllers;

use App\Models\ParticipantResponse;
use App\Models\Bank;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function show($token)
    {
        $response = ParticipantResponse::where('token', $token)->firstOrFail();
        $bank = $response->bank;
        
        // Check if bank link is still active
        if (!$bank->is_active) {
            abort(403, 'Link untuk tes ini sudah ditutup oleh admin. Anda tidak bisa mengakses tes lagi.');
        }

        // Check if already completed
        if ($response->completed) {
            return redirect()->route('test.result', $token)->with('info', 'Tes sudah diselesaikan.');
        }

        // If not yet started, show participant data form
        if (!$response->started_at) {
            $bank = $response->bank;
            return view('test.form', compact('response', 'bank', 'token'));
        }

        // Show questions if form already filled
        $bank = $response->bank;
        $questions = $bank->questions;

        return view('test.show', compact('response', 'bank', 'questions'));
    }

    public function submitForm(Request $request, $token)
    {
        $response = ParticipantResponse::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'participant_name' => 'required|string|max:255',
            'participant_email' => 'required|email|max:255',
            'position' => 'required|string|max:255',
        ]);

        $bank = $response->bank;

        // Check for duplicate: same email already completed this bank's test
        $isDuplicate = ParticipantResponse::where('bank_id', $bank->id)
            ->where('participant_email', $validated['participant_email'])
            ->where('completed', true)
            ->exists();

        if ($isDuplicate) {
            return back()
                ->withInput()
                ->with('duplicate_error', true)
                ->withErrors(['participant_email' => 'anda sudah tidak bisa mengerjakan test ini lagi']);
        }

        // Update response with participant data and mark as started
        $response->update([
            'participant_name' => $validated['participant_name'],
            'participant_email' => $validated['participant_email'],
            'position' => $validated['position'],
            'started_at' => now(),
        ]);

        return redirect()->route('test.show', $token);
    }

    public function submit(Request $request, $token)
    {
        $response = ParticipantResponse::where('token', $token)->firstOrFail();

        $answers = $request->validate([
            'answers' => 'required|array',
            'participant_name' => 'required|string|max:255',
            'participant_email' => 'required|email|max:255',
        ]);

        $questions = $response->bank->questions;
        $score = 0;
        $responses = [];

        foreach ($questions as $question) {
            $userAnswer = $answers['answers'][$question->id] ?? null;
            $responses[$question->id] = $userAnswer;

            if ($question->type === 'text') {
                // Case-insensitive text comparison
                if (strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer_text))) {
                    $score++;
                }
            } else {
                // Multiple choice comparison
                if ($userAnswer === $question->correct_answer) {
                    $score++;
                }
            }
        }

        $totalQuestions = $questions->count();
        $percentage = $totalQuestions > 0 ? round(($score / $totalQuestions) * 100, 2) : 0;

        $response->update([
            'participant_name' => $answers['participant_name'],
            'participant_email' => $answers['participant_email'],
            'responses' => $responses,
            'score' => $score,
            'completed' => true,
            'completed_at' => now(),
        ]);

        return redirect()->route('test.result', $token)->with('score', $score)->with('total', $totalQuestions)->with('percentage', $percentage);
    }

    public function result($token)
    {
        $response = ParticipantResponse::where('token', $token)->firstOrFail();
        if (!$response->completed) {
            return redirect()->route('test.show', $token)->with('warning', 'Silakan selesaikan tes terlebih dahulu.');
        }

        $bank = $response->bank;
        $questions = $bank->questions;
        $total = $questions->count();
        $percentage = $total > 0 ? round(($response->score / $total) * 100, 2) : 0;

        return view('test.result', compact('response', 'bank', 'questions', 'total', 'percentage'));
    }
}
