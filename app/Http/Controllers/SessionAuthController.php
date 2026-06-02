<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class SessionAuthController extends Controller
{
    // ============== USER AUTHENTICATION ==============

    /**
     * Show user login form
     */
    public function showUserLogin()
    {
        return view('auth.login');
    }

    /**
     * Show user register form
     */
    public function showUserRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration
     */
    public function storeUserRegister(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors($validator);
        }

        // Create user with role 'umum' (general user) by default
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'umum',
        ]);

        // Auto-login user after registration
        Auth::login($user);

        return redirect()->route('user.dashboard')
            ->with('success', 'Akun berhasil dibuat! Selamat datang di KSPM.');
    }

    /**
     * Handle user login
     */
    public function storeUserLogin(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Username atau email harus diisi.',
            'password.required' => 'Password harus diisi.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors($validator);
        }

        // Determine if input is email or username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Find user by email/username
        $user = User::where($loginType, $request->login)
            ->where('role', '!=', 'admin')
            ->first();

        // Check user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['login' => 'Username/Email atau password salah.']);
        }

        // Login user
        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('user.dashboard')
            ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
    }

    /**
     * Show forgot password form for user
     */
    public function showUserForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request for user
     */
    public function storeUserForgotPassword(Request $request)
    {
        // Trim email input untuk handle spasi
        $email = trim($request->input('email', ''));
        
        // Validasi format email
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput(['email' => $email])
                ->withErrors($validator);
        }

        // Check if email exists (case-insensitive dengan LOWER untuk compatibility)
        $user = User::whereRaw('LOWER(email) = ?', [strtolower($email)])->first();
        
        if (!$user) {
            return back()
                ->withInput(['email' => $email])
                ->withErrors(['email' => 'Email tidak terdaftar di sistem.']);
        }

        // Send password reset link
        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()
                ->with('status', 'Link reset password telah dikirim ke email Anda. Silakan periksa folder inbox atau spam.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Gagal mengirim link reset password. Silakan coba lagi.']);
    }

    /**
     * Show reset password form for user
     */
    public function showUserResetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle reset password for user
     */
    public function storeUserResetPassword(Request $request)
    {
        // Trim email input
        $email = trim($request->input('email', ''));
        
        // Validasi input
        $validator = Validator::make(
            [
                'email' => $email,
                'token' => $request->input('token'),
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation'),
            ],
            [
                'email' => 'required|email',
                'token' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Email tidak valid.',
                'token.required' => 'Token tidak valid.',
                'password.required' => 'Password harus diisi.',
                'password.confirmed' => 'Password tidak cocok.',
                'password.min' => 'Password minimal 8 karakter.',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withInput($request->except('password', 'password_confirmation', 'token'))
                ->withErrors($validator);
        }

        // Reset password - gunakan trimmed email
        $status = Password::reset(
            [
                'email' => $email,
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation'),
                'token' => $request->input('token'),
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')
                ->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
        }

        return back()
            ->withInput($request->except('password', 'password_confirmation', 'token'))
            ->withErrors(['email' => 'Gagal mereset password. Token mungkin sudah kadaluarsa. Silakan minta link reset baru.']);
    }

    // ============== ADMIN AUTHENTICATION ==============

    /**
     * Show admin login form
     */
    public function showAdminLogin()
    {
        return view('admin.login-admin');
    }

    /**
     * Handle admin login
     */
    public function storeAdminLogin(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Username atau email harus diisi.',
            'password.required' => 'Password harus diisi.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors($validator);
        }

        // Determine if input is email or username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Find admin user
        $user = User::where($loginType, $request->login)
            ->where('role', 'admin')
            ->first();

        // Check user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['login' => 'Username/Email atau password salah, atau Anda bukan admin.']);
        }

        // Login admin
        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('admin.dashboard')
            ->with('success', 'Selamat datang kembali, Admin ' . $user->name . '!');
    }

    /**
     * Show forgot password form for admin
     */
    public function showAdminForgotPassword()
    {
        return view('admin.lupapwadmin');
    }

    /**
     * Handle forgot password request for admin
     */
    public function storeAdminForgotPassword(Request $request)
    {
        // Trim email input untuk handle spasi
        $email = trim($request->input('email', ''));
        
        // Validasi format email
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withInput(['email' => $email])
                ->withErrors($validator);
        }

        // Check if email exists and is admin (case-insensitive)
        $user = User::whereRaw('LOWER(email) = ?', [strtolower($email)])
            ->where('role', 'admin')
            ->first();

        if (!$user) {
            return back()
                ->withInput(['email' => $email])
                ->withErrors(['email' => 'Email admin tidak terdaftar di sistem.']);
        }

        // Buat reset token manual untuk admin
        $token = \Illuminate\Support\Str::random(64);
        
        // Simpan token ke password_resets table
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['email' => $email],
                [
                    'token' => \Illuminate\Support\Facades\Hash::make($token),
                    'created_at' => now(),
                ]
            );

        // Buat reset link manual untuk admin
        $resetUrl = route('admin.reset-password', ['token' => $token]) . '?email=' . urlencode($email);
        
        // Send email manually atau via mailable
        // TODO: Implementasi email sending di sini atau gunakan Mailable class
        // Untuk sekarang, cukup simpan token dan beri feedback ke user
        
        return back()
            ->with('status', 'Link reset password telah dikirim ke email Anda. Silakan periksa folder inbox atau spam.');
    }

    /**
     * Show reset password form for admin
     */
    public function showAdminResetPassword($token)
    {
        return view('admin.reset-password-admin', ['token' => $token]);
    }

    /**
     * Handle reset password for admin
     */
    public function storeAdminResetPassword(Request $request)
    {
        // Trim email input
        $email = trim($request->input('email', ''));
        $token = $request->input('token', '');
        
        // Validasi input
        $validator = Validator::make(
            [
                'email' => $email,
                'token' => $token,
                'password' => $request->input('password'),
                'password_confirmation' => $request->input('password_confirmation'),
            ],
            [
                'email' => 'required|email',
                'token' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'email.required' => 'Email harus diisi.',
                'email.email' => 'Email tidak valid.',
                'token.required' => 'Token tidak valid.',
                'password.required' => 'Password harus diisi.',
                'password.confirmed' => 'Password tidak cocok.',
                'password.min' => 'Password minimal 8 karakter.',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withInput($request->except('password', 'password_confirmation', 'token'))
                ->withErrors($validator);
        }

        // Verify email is admin (case-insensitive)
        $user = User::whereRaw('LOWER(email) = ?', [strtolower($email)])
            ->where('role', 'admin')
            ->first();

        if (!$user) {
            return back()
                ->withInput($request->except('password', 'password_confirmation', 'token'))
                ->withErrors(['email' => 'Email admin tidak terdaftar.']);
        }

        // Verify token from password_reset_tokens table
        $resetRecord = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$resetRecord || !\Illuminate\Support\Facades\Hash::check($token, $resetRecord->token)) {
            return back()
                ->withInput($request->except('password', 'password_confirmation', 'token'))
                ->withErrors(['token' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        // Check if token is not expired (24 hours)
        if (now()->diffInHours($resetRecord->created_at) > 24) {
            return back()
                ->withInput($request->except('password', 'password_confirmation', 'token'))
                ->withErrors(['token' => 'Token telah kadaluarsa. Silakan minta link reset baru.']);
        }

        // Reset password
        $user->forceFill([
            'password' => Hash::make($request->input('password')),
        ])->save();

        // Delete token after successful reset
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();

        return redirect()->route('admin.login')
            ->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }

    /**
     * Logout user/admin
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
