<x-guest-layout>
    <h2>RECUPERAR CONTRASEÑA</h2>
    <p class="subtitle">Te enviaremos un link de recuperación</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <label for="email">Correo electrónico</label>
        <input id="email" class="form-control @error('email') is-invalid @enderror"
               type="email" name="email" value="{{ old('email') }}"
               placeholder="tucorreo@ejemplo.com" required autofocus>
        @error('email')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn-stateless">ENVIAR LINK</button>

        <p class="text-center mt-4" style="font-size:11px; color:rgba(255,255,255,0.5);">
            <a href="{{ route('login') }}">← Volver a iniciar sesión</a>
        </p>
    </form>
</x-guest-layout>