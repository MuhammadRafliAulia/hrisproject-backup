<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            if ($user->isAdminProd()) {
                return redirect()->route('warning-letters.create');
            }
            if ($user->isRecruitmentTeam()) {
                return redirect()->route('recruitment.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|min:3|max:255',
            'password' => 'required|string',
        ]);

        $login = $request->input('email');
        $password = $request->input('password');

        // Try login with email first, then with name
        if (Auth::attempt(['email' => $login, 'password' => $password]) ||
            Auth::attempt(['name' => $login, 'password' => $password])) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();
            ActivityLog::log('login', 'auth', 'User ' . $user->name . ' berhasil login');

            if ($user->isAdminProd()) {
                return redirect()->intended(route('warning-letters.create'));
            }
            if ($user->isRecruitmentTeam()) {
                return redirect()->intended(route('recruitment.dashboard'));
            }
            if ($user->isTopLevelManagement()) {
                return redirect()->intended(route('dashboard'));
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Username/email atau password salah. Silakan coba lagi.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        ActivityLog::log('logout', 'auth', 'User ' . Auth::user()->name . ' logout');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
