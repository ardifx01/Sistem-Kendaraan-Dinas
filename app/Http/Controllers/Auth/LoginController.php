<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Try to authenticate with username
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'username' => 'Akun Anda tidak aktif. Hubungi administrator.',
                ]);
            }

            $request->session()->regenerate();

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->isOperator()) {
                return redirect()->intended(route('operator.dashboard'));
            }
        }

        throw ValidationException::withMessages([
            'username' => 'Username atau password tidak valid.',
        ]);
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
