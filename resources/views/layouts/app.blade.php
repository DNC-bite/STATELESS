<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>STATELESS</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fff;
            color: #000;
        }

        /* NAVBAR */
        .navbar-stateless {
            background-color: #000;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-stateless .brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 28px;
            color: #fff;
            text-decoration: none;
            letter-spacing: 4px;
        }

        .navbar-stateless .nav-links {
            display: flex;
            gap: 35px;
            list-style: none;
            margin: 0;
        }

        .navbar-stateless .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: opacity 0.2s;
        }

        .navbar-stateless .nav-links a:hover { opacity: 0.6; }

        .navbar-stateless .nav-actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .navbar-stateless .nav-actions a {
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: opacity 0.2s;
        }

        .navbar-stateless .nav-actions a:hover { opacity: 0.6; }

        .btn-stateless {
            background-color: #000;
            color: #fff;
            border: 2px solid #000;
            padding: 10px 28px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-stateless:hover {
            background-color: #fff;
            color: #000;
        }

        .btn-stateless-outline {
            background-color: #fff;
            color: #000;
            border: 2px solid #000;
            padding: 10px 28px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-stateless-outline:hover {
            background-color: #000;
            color: #fff;
        }

        /* FOOTER */
        .footer-stateless {
            background-color: #000;
            color: #fff;
            padding: 40px;
            text-align: center;
            margin-top: 80px;
        }

        .footer-stateless .brand {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 32px;
            letter-spacing: 6px;
            margin-bottom: 10px;
        }

        .footer-stateless p {
            font-size: 12px;
            opacity: 0.5;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar-stateless">
        <a href="{{ url('/') }}" class="brand">STATELESS</a>

        <ul class="nav-links">
            <li><a href="{{ url('/') }}">Inicio</a></li>
            <li><a href="#">Essentials</a></li>
            <li><a href="#">The Chroma Life</a></li>
        </ul>

        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}">Mi cuenta</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#fff; font-size:12px; letter-spacing:1px; text-transform:uppercase; cursor:pointer; opacity:1;" onmouseover="this.style.opacity=0.6" onmouseout="this.style.opacity=1">Salir</button>
                </form>
            @else
                <a href="{{ route('login') }}">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn-stateless">Registrarse</a>
            @endauth
        </div>
    </nav>

    <!-- CONTENIDO -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer-stateless">
        <div class="brand">STATELESS</div>
        <p>© {{ date('Y') }} STATELESS. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>