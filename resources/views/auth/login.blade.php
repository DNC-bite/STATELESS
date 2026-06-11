<x-guest-layout>
    <h2 class="mb-4 text-center">Iniciar Sesión</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" type="password" class="form-control" name="password" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="remember" id="remember">
            <label class="form-check-label" for="remember">Recordarme</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>
    {{-- Alerta si no verificó el email --}}
@if(session('email_no_verificado'))
<div class="alert alert-warning d-flex justify-content-between align-items-center mt-2">
    <span>Cuenta sin verificar.</span>
    <form action="{{ route('verification.send') }}" method="POST" class="m-0">
        @csrf
        <button class="btn btn-sm btn-warning">Reenviar correo</button>
    </form>
</div>
@endif

{{-- Enlace olvidaste contraseña --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <label class="form-label mb-0">Contraseña</label>
    <a href="{{ route('password.request') }}" class="small text-muted">¿Olvidaste tu contraseña?</a>
</div>

    <div class="mt-3 text-center">
        <span>¿No tienes cuenta?</span>
        <a href="{{ route('register') }}">Regístrate aquí</a>
    </div>
</x-guest-layout>