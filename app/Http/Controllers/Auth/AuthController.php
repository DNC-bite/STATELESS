<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RecuperarPasswordMail;
use App\Mail\VerificarEmailMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ─── REGISTRO ───────────────────────────────────────────
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $token = Str::random(64);

        $user = User::create([
            'name'                   => $request->name,
            'email'                  => $request->email,
            'password'               => Hash::make($request->password),
            'role_id'                => 3, // cliente
            'email_verified'         => false,
            'email_token'            => $token,
            'email_token_expires_at' => now()->addHours(24),
        ]);

        $url = route('auth.verificar', ['token' => $token]);
        Mail::to($user->email)->send(new VerificarEmailMail($url, $user->name));

        return redirect()->route('auth.pendiente')
            ->with('email', $user->email);
    }

    // ─── VERIFICAR EMAIL ────────────────────────────────────
    public function pendienteVerificacion()
    {
        return view('auth.pendiente-verificacion');
    }

    public function verificarEmail(string $token)
    {
        $user = User::where('email_token', $token)->first();

        if (!$user || $user->email_token_expires_at->isPast()) {
            return redirect()->route('login')
                ->with('error', 'El enlace de verificación es inválido o expiró.');
        }

        $user->update([
            'email_verified'         => true,
            'email_token'            => null,
            'email_token_expires_at' => null,
        ]);

        return redirect()->route('login')
            ->with('success', '¡Cuenta verificada! Ya puedes iniciar sesión.');
    }

    public function reenviarVerificacion(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)
                    ->where('email_verified', false)->first();

        if (!$user) {
            return back()->with('error', 'No encontramos esa cuenta o ya está verificada.');
        }

        $token = Str::random(64);
        $user->update([
            'email_token'            => $token,
            'email_token_expires_at' => now()->addHours(24),
        ]);

        $url = route('auth.verificar', ['token' => $token]);
        Mail::to($user->email)->send(new VerificarEmailMail($url, $user->name));

        return back()->with('success', 'Correo reenviado. Revisa tu bandeja.');
    }

    // ─── LOGIN ──────────────────────────────────────────────
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Credenciales incorrectas.']);
        }

        if (!$user->email_verified) {
            return back()->withErrors([
                'email' => 'Debes verificar tu correo antes de ingresar.',
            ])->with('email_no_verificado', $user->email);
        }

        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('account');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // ─── RECUPERAR CONTRASEÑA ───────────────────────────────
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        // Respuesta genérica por seguridad (no revelar si el email existe)
        if (!$user) {
            return back()->with('success', 'Si ese correo existe, recibirás un enlace en breve.');
        }

        $token = Str::random(64);
        $user->update([
            'reset_token'            => $token,
            'reset_token_expires_at' => now()->addHour(),
        ]);

        $url = route('auth.reset.form', ['token' => $token]);
        Mail::to($user->email)->send(new RecuperarPasswordMail($url, $user->name));

        return back()->with('success', 'Si ese correo existe, recibirás un enlace en breve.');
    }

    public function showResetForm(string $token)
    {
        $user = User::where('reset_token', $token)->first();

        if (!$user || $user->reset_token_expires_at->isPast()) {
            return redirect()->route('auth.forgot')
                ->with('error', 'El enlace expiró o es inválido. Solicita uno nuevo.');
        }

        return view('auth.reset-password', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('reset_token', $request->token)->first();

        if (!$user || $user->reset_token_expires_at->isPast()) {
            return redirect()->route('auth.forgot')
                ->with('error', 'El enlace expiró. Solicita uno nuevo.');
        }

        $user->update([
            'password'               => Hash::make($request->password),
            'reset_token'            => null,
            'reset_token_expires_at' => null,
        ]);

        return redirect()->route('login')
            ->with('success', '¡Contraseña actualizada! Ya puedes iniciar sesión.');
    }
}