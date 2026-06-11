<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Factura #{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; color: #000; padding: 40px; }

        .header { display: flex; justify-content: space-between; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 2px solid #000; }
        .brand { font-size: 32px; font-weight: 900; letter-spacing: 6px; }
        .factura-num { text-align: right; }
        .factura-num h2 { font-size: 20px; font-weight: 700; letter-spacing: 2px; }
        .factura-num p { font-size: 12px; color: #666; margin-top: 4px; }

        .badge { background: #000; color: #fff; padding: 12px 20px; margin-bottom: 28px; }
        .badge h3 { font-size: 16px; letter-spacing: 2px; }
        .badge p { font-size: 11px; opacity: 0.6; margin-top: 4px; }

        .grid { display: flex; gap: 40px; margin-bottom: 28px; }
        .grid-item { flex: 1; }
        .label { font-size: 9px; letter-spacing: 2px; text-transform: uppercase; color: #999; margin-bottom: 6px; }
        .value { font-size: 13px; font-weight: 600; }
        .value-sub { font-size: 12px; color: #666; margin-top: 2px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead th { font-size: 10px; letter-spacing: 2px; text-transform: uppercase; padding: 10px 0; border-bottom: 2px solid #000; text-align: left; }
        thead th:last-child { text-align: right; }
        tbody td { padding: 14px 0; font-size: 12px; border-bottom: 1px solid #eee; }
        tbody td:last-child { text-align: right; font-weight: 600; }
        tfoot td { padding: 16px 0; font-size: 18px; font-weight: 900; letter-spacing: 2px; }
        tfoot td:last-child { text-align: right; }

        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; font-size: 11px; color: #999; letter-spacing: 1px; }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <div class="brand">STATELESS</div>
            <p style="font-size:10px; letter-spacing:2px; color:#999; margin-top:4px;">FACTURA ELECTRÓNICA</p>
        </div>
        <div class="factura-num">
            <h2>FACTURA #{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}</h2>
            <p>{{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="badge">
        <h3>✓ PAGO CONFIRMADO</h3>
        <p>Tu pedido ha sido procesado correctamente.</p>
    </div>

    <div class="grid">
        <div class="grid-item">
            <div class="label">Cliente</div>
            <div class="value">{{ $venta->usuario->name }}</div>
            <div class="value-sub">{{ $venta->usuario->email }}</div>
        </div>
        <div class="grid-item">
            <div class="label">Envío</div>
            <div class="value">{{ $venta->envio->direccion ?? '—' }}</div>
            <div class="value-sub">{{ $venta->envio->ciudad ?? '—' }}</div>
        </div>
        <div class="grid-item">
            <div class="label">Método de pago</div>
            <div class="value">{{ ucfirst($venta->metodo_pago) }}</div>
            <div class="value-sub">{{ ucfirst($venta->tipo_venta) }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Pedido #{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}<br>
                    <span style="color:#666;">{{ ucfirst($venta->tipo_venta) }} — {{ ucfirst($venta->metodo_pago) }}</span>
                </td>
                <td>${{ number_format($venta->total, 2) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>TOTAL</td>
                <td>${{ number_format($venta->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>STATELESS © {{ date('Y') }} — Todos los derechos reservados</p>
    </div>

</body>
</html>