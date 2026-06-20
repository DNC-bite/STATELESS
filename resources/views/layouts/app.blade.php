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
            <li><a href="{{ route('essentials') }}">Essentials</a></li>
            <li><a href="{{ route('waves') }}">Waves</a></li>
            <li><a href="{{ route('octane') }}">Octane</a></li>
        </ul>

        <div class="nav-actions">
        @auth
    <a href="{{ route('carrito.index') }}" style="position:relative; display:inline-flex; align-items:center; gap:6px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h13M10 21a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
        </svg>
        @php
            $cantidadCarrito = 0;
            if(Auth::check()) {
                $carritoNav = \App\Models\Carrito::where('user_id', Auth::id())->first();
                $cantidadCarrito = $carritoNav ? $carritoNav->items->sum('cantidad') : 0;
            }
        @endphp
       <span id="carrito-contador" 
    @if($cantidadCarrito > 0) style="background:#fff; color:#000; border-radius:50%; width:18px; height:18px; font-size:10px; display:flex; align-items:center; justify-content:center; font-weight:700;" 
    @else style="display:none;" 
    @endif>{{ $cantidadCarrito }}</span>
    </a>
    @if(auth()->user()->hasVerifiedEmail())
    <a href="{{ route('account') }}">Mi Cuenta</a>
    @endif
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
        @auth
        <div id="session-warning" style="
            display:none;
            position:fixed;
            bottom:24px;
            right:24px;
            background:#000;
            color:#fff;
            padding:20px 24px;
            z-index:9999;
            font-family:'Inter',sans-serif;
            font-size:13px;
            max-width:300px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        ">
            <p style="margin-bottom:12px;">⚠️ Tu sesión cerrará en <span id="countdown">2:00</span> por inactividad.</p>
            <button onclick="resetTimer()" style="
                background:#fff;
                color:#000;
                border:none;
                padding:8px 16px;
                font-size:12px;
                font-weight:600;
                letter-spacing:1px;
                cursor:pointer;
                width:100%;
            ">SEGUIR CONECTADO</button>
        </div>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
            @csrf
        </form>

        <script>
        const INACTIVITY_LIMIT = 30 * 60; // 30 minutos en segundos
        const WARNING_TIME = 2 * 60;      // aviso 2 minutos antes
        let timer = INACTIVITY_LIMIT;
        let interval;

        function startTimer() {
            clearInterval(interval);
            interval = setInterval(() => {
                timer--;

                // Mostrar aviso cuando quedan 2 minutos
                if (timer <= WARNING_TIME) {
                    document.getElementById('session-warning').style.display = 'block';
                    const min = Math.floor(timer / 60);
                    const sec = timer % 60;
                    document.getElementById('countdown').textContent =
                        `${min}:${sec.toString().padStart(2, '0')}`;
                }

                // Cerrar sesión cuando llega a 0
                if (timer <= 0) {
                    document.getElementById('logout-form').submit();
                }
            }, 1000);
        }

        function resetTimer() {
            timer = INACTIVITY_LIMIT;
            document.getElementById('session-warning').style.display = 'none';
            startTimer();
        }

        // Reinicia el timer con cualquier actividad
        ['mousemove', 'keypress', 'click', 'scroll', 'touchstart'].forEach(event => {
            document.addEventListener(event, resetTimer);
        });

        startTimer();
        </script>
        @endauth
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>