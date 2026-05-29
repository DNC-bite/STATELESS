<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>STATELESS | Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            color: #000;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background-color: #000;
            color: #fff;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 22px;
            letter-spacing: 4px;
            padding: 28px 24px;
            border-bottom: 1px solid #222;
        }

        .sidebar-subtitle {
            font-size: 10px;
            letter-spacing: 2px;
            opacity: 0.4;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
        }

        .sidebar-nav a {
            display: block;
            padding: 12px 24px;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.6;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            opacity: 1;
            border-left-color: #fff;
            background-color: #111;
        }

        .sidebar-footer {
            padding: 20px 24px;
            border-top: 1px solid #222;
            font-size: 11px;
            opacity: 0.4;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            background-color: #fff;
            padding: 16px 32px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 24px;
            letter-spacing: 3px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 12px;
        }

        .topbar-actions a {
            color: #000;
            text-decoration: none;
            letter-spacing: 1px;
            text-transform: uppercase;
            opacity: 0.6;
            transition: opacity 0.2s;
        }

        .topbar-actions a:hover { opacity: 1; }

        .page-body {
            padding: 32px;
        }

        /* CARDS */
        .stat-card {
            background: #fff;
            border: 1px solid #eee;
            padding: 24px;
            margin-bottom: 24px;
        }

        .stat-card .stat-label {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.5;
            margin-bottom: 8px;
        }

        .stat-card .stat-value {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 36px;
            letter-spacing: 2px;
        }

        /* TABLE */
        .stateless-table {
            width: 100%;
            background: #fff;
            border: 1px solid #eee;
        }

        .stateless-table thead th {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 16px 20px;
            border-bottom: 2px solid #000;
            font-weight: 600;
        }

        .stateless-table tbody td {
            padding: 14px 20px;
            font-size: 13px;
            border-bottom: 1px solid #f0f0f0;
        }

        .stateless-table tbody tr:hover { background-color: #fafafa; }

        /* BUTTONS */
        .btn-sl {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 8px 20px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: opacity 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-sl:hover { opacity: 0.7; color: #fff; }

        .btn-sl-outline {
            background-color: #fff;
            color: #000;
            border: 1px solid #000;
            padding: 8px 20px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-sl-outline:hover { background-color: #000; color: #fff; }

        .btn-sl-danger {
            background-color: #fff;
            color: #c00;
            border: 1px solid #c00;
            padding: 8px 20px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-sl-danger:hover { background-color: #c00; color: #fff; }

        /* FORMS */
        .sl-form-group { margin-bottom: 20px; }

        .sl-label {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .sl-input {
            width: 100%;
            border: 1px solid #ddd;
            padding: 12px 16px;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }

        .sl-input:focus { border-color: #000; }

        .alert-success-sl {
            background-color: #000;
            color: #fff;
            padding: 12px 20px;
            font-size: 12px;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-brand">
            STATELESS
            <div class="sidebar-subtitle">Panel Administrador</div>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ url('/dashboard') }}">Inicio</a>
            <a href="{{ route('ventas.index') }}">Ventas</a>
            <a href="{{ route('usuarios.index') }}">Usuarios</a>
            <a href="{{ route('inventarios.index') }}">Inventario</a>
            <a href="{{ route('envios.index') }}">Envíos</a>
            <a href="{{ route('productos.index') }}">Productos</a>
            <a href="{{ route('proveedores.index') }}">Proveedores</a>
            <a href="{{ route('categorias.index') }}">Categorías</a>
        </nav>
        <div class="sidebar-footer">
            {{ Auth::user()->name ?? 'Admin' }}
        </div>
    </div>

    <!-- MAIN -->
    <div class="main-content">
        <div class="topbar">
            <div class="topbar-title">@yield('page-title', 'PANEL')</div>
            <div class="topbar-actions">
                <a href="{{ url('/') }}">Ver tienda</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" style="background:none; border:none; font-size:11px; letter-spacing:1px; text-transform:uppercase; cursor:pointer; opacity:0.6;">Salir</button>
                </form>
            </div>
        </div>
        <div class="page-body">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>