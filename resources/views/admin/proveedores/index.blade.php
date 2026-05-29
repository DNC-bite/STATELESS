@extends('layouts.admin')

@section('page-title', 'PROVEEDORES')

@section('content')

@if(session('success'))
    <div class="alert-success-sl">{{ session('success') }}</div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-family:'Bebas Neue', sans-serif; font-size:32px; letter-spacing:3px;">Lista de Proveedores</h2>
    <a href="{{ route('proveedores.create') }}" class="btn-sl">+ Registrar</a>
</div>

<table class="stateless-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($proveedores as $proveedor)
        <tr>
            <td>{{ $proveedor->id }}</td>
            <td>{{ $proveedor->nombre }}</td>
            <td>{{ $proveedor->telefono }}</td>
            <td>{{ $proveedor->correo }}</td>
            <td>{{ $proveedor->estado ? 'Activo' : 'Inactivo' }}</td>
            <td style="display:flex; gap:8px;">
                <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn-sl-outline">Editar</a>
                <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-sl-danger" onclick="return confirm('¿Eliminar este proveedor?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center; opacity:0.5; padding:40px;">No hay proveedores registrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection