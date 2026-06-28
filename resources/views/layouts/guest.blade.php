<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Stateless') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&family=bebas-neue&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background:#000;
            margin:0;
            overflow-x:hidden;
            font-family:'Inter', sans-serif;
        }
        #wavesCanvas {
            position:fixed;
            top:0; left:0;
            width:100%; height:100%;
            z-index:0;
        }
        .auth-brand {
            position:fixed;
            top:24px; left:32px;
            color:#fff;
            font-family:'Bebas Neue', sans-serif;
            font-size:22px;
            letter-spacing:3px;
            z-index:2;
        }
        .auth-card {
            position:relative;
            z-index:2;
            background:rgba(0,0,0,0.55);
            border:1px solid rgba(255,255,255,0.15);
            padding:40px 36px;
            width:100%;
            max-width:380px;
            backdrop-filter:blur(6px);
        }
        .auth-card label {
            color:rgba(255,255,255,0.7);
            font-size:11px;
            letter-spacing:1px;
            text-transform:uppercase;
            margin-bottom:6px;
            display:block;
        }
        .auth-card .form-control {
            width:100%;
            background:rgba(255,255,255,0.05);
            border:1px solid rgba(255,255,255,0.2);
            color:#fff;
            padding:10px 12px;
            margin-bottom:16px;
            font-size:13px;
            border-radius:0;
        }
        .auth-card .form-control:focus {
            background:rgba(255,255,255,0.08);
            border-color:rgba(255,255,255,0.4);
            color:#fff;
            box-shadow:none;
        }
        .auth-card .form-control::placeholder {
            color:rgba(255,255,255,0.3);
        }
        .auth-card .btn-stateless {
            width:100%;
            background:#fff;
            color:#000;
            border:none;
            padding:12px;
            font-family:'Bebas Neue', sans-serif;
            letter-spacing:2px;
            font-size:14px;
            cursor:pointer;
            border-radius:0;
        }
        .auth-card .btn-stateless:hover {
            background:#eee;
            color:#000;
        }
        .auth-card a {
            color:rgba(255,255,255,0.6);
        }
        .auth-card a:hover {
            color:#fff;
        }
        .auth-card h2 {
            font-family:'Bebas Neue', sans-serif;
            color:#fff;
            font-size:28px;
            letter-spacing:2px;
            margin:0 0 4px;
        }
        .auth-card .subtitle {
            color:rgba(255,255,255,0.5);
            font-size:12px;
            margin:0 0 24px;
        }
        .auth-card .form-check-label {
            color:rgba(255,255,255,0.6);
            font-size:12px;
        }
        .auth-card .alert {
            font-size:12px;
            border-radius:0;
        }
        .auth-card .invalid-feedback,
        .auth-card .text-danger {
            color:#ff8a8a !important;
            font-size:11px;
        }
    </style>
</head>
<body>
    <canvas id="wavesCanvas"></canvas>
    <div class="auth-brand"><a href="/" style="color:#fff; text-decoration:none;">STATELESS</a></div>

    <div class="min-vh-100 d-flex justify-content-center align-items-center py-4" style="position:relative; z-index:2;">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const canvas = document.getElementById('wavesCanvas');
        const ctx = canvas.getContext('2d');
        let w, h, dots = [];

        function resize() {
            w = canvas.width = window.innerWidth;
            h = canvas.height = window.innerHeight;
            dots = [];
            const spacing = 26;
            for (let x = 0; x < w + spacing; x += spacing) {
                for (let y = 0; y < h + spacing; y += spacing) {
                    dots.push({ baseX: x, baseY: y });
                }
            }
        }
        resize();
        window.addEventListener('resize', resize);

        let t = 0;
        function animate() {
            t += 0.012;
            ctx.clearRect(0, 0, w, h);
            for (const d of dots) {
                const dx = (d.baseX - w / 2) / w;
                const dy = (d.baseY - h / 2) / h;
                const dist = Math.sqrt(dx * dx + dy * dy);
                const wave = Math.sin(dist * 10 - t * 2) * 0.5 + 0.5;
                const size = 1 + wave * 2.2;
                const alpha = 0.12 + wave * 0.45;
                ctx.beginPath();
                ctx.arc(d.baseX, d.baseY, size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(255,255,255,${alpha})`;
                ctx.fill();
            }
            requestAnimationFrame(animate);
        }
        animate();
    </script>
</body>
</html>