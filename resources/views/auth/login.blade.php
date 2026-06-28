<x-guest-layout>
    <h2>INICIAR SESIÓN</h2>
    <p class="subtitle">Accede a tu cuenta Stateless</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">Correo electrónico</label>
        <input id="email" class="form-control @error('email') is-invalid @enderror"
               type="email" name="email" value="{{ old('email') }}"
               placeholder="tucorreo@ejemplo.com" required autofocus>
        @error('email')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label for="password">Contraseña</label>
        <input id="password" class="form-control @error('password') is-invalid @enderror"
               type="password" name="password" placeholder="••••••••" required>
        @error('password')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Recordarme</label>
        </div>

        <button type="submit" class="btn-stateless">INGRESAR</button>

        <div class="d-flex justify-content-between mt-3" style="font-size:11px;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
        </div>
        <p class="text-center mt-4" style="font-size:11px; color:rgba(255,255,255,0.5);">
            ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
        </p>
    </form>
</x-guest-layout>