@extends('layouts.admin')

@section('page-title', 'USUARIOS')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Registrar Usuario</h2>
    <a href="{{ route('usuarios.index') }}" class="btn-sl-outline">← Volver</a>
</div>

@if($errors->any())
    <div style="background:#fff0f0; border:1px solid #c00; padding:12px 20px; margin-bottom:24px; font-size:13px;">
        <ul style="margin:0; padding-left:16px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="background:#fff; border:1px solid #eee; padding:32px; max-width:600px;">
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="sl-form-group">
            <label class="sl-label">Nombre</label>
            <input type="text" name="name" class="sl-input" value="{{ old('name') }}" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Email</label>
            <input type="email" name="email" class="sl-input" value="{{ old('email') }}" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Contraseña</label>
            <input type="password" name="password" class="sl-input" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="sl-input" required>
        </div>
        <div class="sl-form-group">
            <label class="sl-label">Rol</label>
            <select name="role_id" class="sl-input" required>
                <option value="">Seleccionar...</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="display:flex; gap:12px; margin-top:8px;">
            <button type="submit" class="btn-sl">Registrar</button>
            <a href="{{ route('usuarios.index') }}" class="btn-sl-outline">Cancelar</a>
        </div>
    </form>
</div>

@endsection