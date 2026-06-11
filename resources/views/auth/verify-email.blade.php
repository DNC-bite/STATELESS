@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="card mx-auto shadow" style="max-width:500px">
        <div class="card-body p-5 text-center">

            <div class="fs-1 mb-3">📧</div>
            <h4 class="fw-bold mb-2">Verifica tu correo</h4>
            <p class="text-muted mb-1">
                Te enviamos un enlace de verificación a:
            </p>
            <p class="fw-bold mb-3">{{ auth()->user()->email }}</p>
            <p class="text-muted small mb-4">
                Ábrelo desde cualquier dispositivo — computador, celular o tablet.
                El enlace expira en 60 minutos.
            </p>

            @if(session('status') == 'verification-link-sent')
                <div class="alert alert-success">
                    ✅ Correo reenviado. Revisa tu bandeja y la carpeta de spam.
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="btn btn-dark w-100 mb-3">
                    Reenviar correo de verificación
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-secondary w-100">
                    Cerrar sesión
                </button>
            </form>

        </div>
    </div>
</div>
@endsection