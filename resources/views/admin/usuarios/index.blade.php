@extends('layouts.admin')

@section('page-title', 'USUARIOS')

@section('content')

@if(session('success'))
    <div class="alert-success-sl">{{ session('success') }}</div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Lista de Usuarios</h2>
    <a href="{{ route('usuarios.create') }}" class="btn-sl">+ Registrar</a>
</div>

<table class="stateless-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
    <form action="{{ route('usuarios.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="estado" value="{{ $user->estado }}">
        <select name="role_id" onchange="this.form.submit()"
            style="padding:6px 10px; border:1px solid #ddd; font-size:12px;">
            @foreach($roles as $rol)
                <option value="{{ $rol->id }}" {{ $user->role_id == $rol->id ? 'selected' : '' }}>
                    {{ ucfirst($rol->name) }}
                </option>
            @endforeach
        </select>
    </form>
</td>
            <td>
                @if($user->estado === 'activo')
                    <span style="background:green; color:#fff; padding:2px 8px; font-size:10px;">ACTIVO</span>
                @else
                    <span style="background:#c00; color:#fff; padding:2px 8px; font-size:10px;">INACTIVO</span>
                @endif
            </td>
            <td style="display:flex; gap:8px;">
                @if($user->estado === 'activo')
                    <form action="{{ route('usuarios.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="role_id" value="{{ $user->role_id }}">
                        <input type="hidden" name="estado" value="inactivo">
                        <button type="submit" class="btn-sl-danger" onclick="return confirm('¿Inhabilitar este usuario?')">Inhabilitar</button>
                    </form>
                @else
                    <form action="{{ route('usuarios.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="role_id" value="{{ $user->role_id }}">
                        <input type="hidden" name="estado" value="activo">
                        <button type="submit" class="btn-sl" onclick="return confirm('¿Habilitar este usuario?')">Habilitar</button>
                    </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center; opacity:0.5; padding:40px;">No hay usuarios registrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection