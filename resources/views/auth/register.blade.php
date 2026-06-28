<x-guest-layout>
    <h2>CREAR CUENTA</h2>
    <p class="subtitle">Únete a Stateless</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="name">Nombre</label>
        <input id="name" class="form-control @error('name') is-invalid @enderror"
               type="text" name="name" value="{{ old('name') }}"
               placeholder="Tu nombre completo" required autofocus>
        @error('name')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label for="email">Correo electrónico</label>
        <input id="email" class="form-control @error('email') is-invalid @enderror"
               type="email" name="email" value="{{ old('email') }}"
               placeholder="tucorreo@ejemplo.com" required>
        @error('email')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label for="password">Contraseña</label>
        <input id="password" class="form-control @error('password') is-invalid @enderror"
               type="password" name="password" placeholder="••••••••" required>
        @error('password')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label for="password_confirmation">Confirmar contraseña</label>
        <input id="password_confirmation" class="form-control"
               type="password" name="password_confirmation" placeholder="••••••••" required>

        <button type="submit" class="btn-stateless">REGISTRARME</button>

        <p class="text-center mt-4" style="font-size:11px; color:rgba(255,255,255,0.5);">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
        </p>
    </form>
</x-guest-layout>