<x-guest-layout>
    <h2>NUEVA CONTRASEÑA</h2>
    <p class="subtitle">Crea una contraseña segura</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <label for="email">Correo electrónico</label>
        <input id="email" class="form-control @error('email') is-invalid @enderror"
               type="email" name="email" value="{{ old('email', $request->email) }}"
               placeholder="tucorreo@ejemplo.com" required autofocus>
        @error('email')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label for="password">Nueva contraseña</label>
        <input id="password" class="form-control @error('password') is-invalid @enderror"
               type="password" name="password" placeholder="••••••••" required>
        @error('password')
            <div class="text-danger mb-2">{{ $message }}</div>
        @enderror

        <label for="password_confirmation">Confirmar contraseña</label>
        <input id="password_confirmation" class="form-control"
               type="password" name="password_confirmation" placeholder="••••••••" required>

        <button type="submit" class="btn-stateless">RESTABLECER</button>
    </form>
</x-guest-layout>