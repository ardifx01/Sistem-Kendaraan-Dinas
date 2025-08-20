<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

        /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar dalam sistem. Silakan periksa kembali email Anda atau hubungi administrator.');
        }

        // Delete any existing reset tokens for this email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Create a new token
        $token = Str::random(64);

        // Store the token in the database
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now()
        ]);

        \Log::info('Password reset token created, redirecting to reset form', [
            'email' => $request->email,
            'token' => $token,
            'user_id' => $user->id
        ]);

        // Redirect langsung ke halaman reset password dengan token
        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $request->email
        ])->with('status', 'Silakan masukkan password baru Anda!');
    }

    /**
     * Show the reset password form.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset the given user's password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'token.required' => 'Token reset password tidak valid.'
        ]);

        // Find the password reset record
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return back()->with('error', 'Token reset password tidak valid atau sudah kadaluarsa.');
        }

        // Check if token is valid (check if the token matches)
        if (!Hash::check($request->token, $passwordReset->token)) {
            return back()->with('error', 'Token reset password tidak valid.');
        }

        // Check if token is not expired (optional: you can set expiration time)
        $tokenAge = Carbon::parse($passwordReset->created_at)->diffInHours(Carbon::now());
        if ($tokenAge > 24) { // Token expires after 24 hours
            // Delete expired token
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->with('error', 'Token reset password sudah kadaluarsa. Silakan ajukan reset password baru.');
        }

        // Find the user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the used token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        \Log::info('Password reset successful', [
            'email' => $request->email,
            'user_id' => $user->id
        ]);

        // Redirect to login with success message
        return redirect()->route('login')->with('status', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }
}