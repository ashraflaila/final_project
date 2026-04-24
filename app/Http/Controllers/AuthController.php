<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Student;
use App\Models\Teacher;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        }

        if (Auth::guard('teacher')->check()) {
            return redirect()->route('teacher.dashboard');
        }

        if (Auth::guard('student')->check()) {
            return redirect()->route('student.dashboard');
        }

        if (Auth::guard('web')->check()) {
            return redirect()->route('user.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        if (Auth::guard('teacher')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('teacher.dashboard'));
        }

        if (Auth::guard('student')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('student.dashboard'));
        }

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::guard('web')->user();
            $actor = $user?->actor;

            if ($actor instanceof Teacher) {
                return redirect()->intended(route('teacher.dashboard'));
            }

            if ($actor instanceof Student) {
                return redirect()->intended(route('student.dashboard'));
            }

            return redirect()->intended(route('user.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'بيانات تسجيل الدخول غير صحيحة.',
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('teacher')->check()) {
            Auth::guard('teacher')->logout();
        } elseif (Auth::guard('student')->check()) {
            Auth::guard('student')->logout();
        } else {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
