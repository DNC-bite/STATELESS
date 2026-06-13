@extends('layouts.app')

@section('content')
<section style="padding: 80px 60px; max-width: 800px; margin: 0 auto;">
    
    <h1 style="font-family:'Bebas Neue', sans-serif; font-size:48px; letter-spacing:4px; margin-bottom:8px;">MI CUENTA</h1>
    <p style="font-size:13px; opacity:0.5; letter-spacing:1px; margin-bottom:40px;">Bienvenido, {{ Auth::user()->name }}</p>

    <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:20px;">

        <!-- Perfil -->
        <a href="{{ route('profile.edit') }}" style="text-decoration:none; color:#000;">
            <div style="border:1px solid #eee; padding:28px; transition:border-color 0.2s;" onmouseover="this.style.borderColor='#000'" onmouseout="this.style.borderColor='#eee'">
                <p style="font-size:10px; letter-spacing:3px; text-transform:uppercase; opacity:0.4; margin-bottom:8px;">Cuenta</p>
                <p style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px;">Mi Perfil</p>
                <p style="font-size:12px; opacity:0.5; margin-top:8px;">Editar nombre y correo</p>
            </div>
        </a>

        @if(Auth::user()->role && Auth::user()->role->name === 'admin')
        <!-- Panel Admin -->
        <a href="{{ route('admin.dashboard') }}" style="text-decoration:none; color:#000;">
            <div style="border:1px solid #000; background:#000; color:#fff; padding:28px; transition:opacity 0.2s;" onmouseover="this.style.opacity=0.8" onmouseout="this.style.opacity=1">
                <p style="font-size:10px; letter-spacing:3px; text-transform:uppercase; opacity:0.4; margin-bottom:8px;">Administración</p>
                <p style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px;">Panel Admin</p>
                <p style="font-size:12px; opacity:0.5; margin-top:8px;">Gestionar tienda completa</p>
            </div>
        </a>
        @endif

        @if(Auth::user()->role && Auth::user()->role->name === 'empleado')
        <!-- Panel Empleado -->
        <a href="{{ url('/empleado/ventas') }}" style="text-decoration:none; color:#000;">
            <div style="border:1px solid #000; background:#000; color:#fff; padding:28px;">
                <p style="font-size:10px; letter-spacing:3px; text-transform:uppercase; opacity:0.4; margin-bottom:8px;">Empleado</p>
                <p style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px;">Panel Empleado</p>
                <p style="font-size:12px; opacity:0.5; margin-top:8px;">Gestionar ventas e inventario</p>
            </div>
        </a>
        @endif

        @if(Auth::user()->role && Auth::user()->role->name === 'cliente')
        <!-- Mis Pedidos -->
        <a href="#" style="text-decoration:none; color:#000;">
            <div style="border:1px solid #eee; padding:28px;" onmouseover="this.style.borderColor='#000'" onmouseout="this.style.borderColor='#eee'">
                <p style="font-size:10px; letter-spacing:3px; text-transform:uppercase; opacity:0.4; margin-bottom:8px;">Compras</p>
                <p style="font-family:'Bebas Neue', sans-serif; font-size:24px; letter-spacing:2px;">Mis Pedidos</p>
                <p style="font-size:12px; opacity:0.5; margin-top:8px;">Ver historial de compras</p>
            </div>
        </a>
        @endif

    </div>

    <!-- Cerrar sesión -->
    <div style="margin-top:40px; padding-top:24px; border-top:1px solid #eee;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none; border:none; font-size:12px; letter-spacing:2px; text-transform:uppercase; cursor:pointer; opacity:0.4;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.4">Cerrar Sesión</button>
        </form>
    </div>

</section>
@endsection