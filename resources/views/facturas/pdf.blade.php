<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura </title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            margin: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
        }

        .info p {
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 7px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 15px;
            margin-top: 10px;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
        }

        .pagada {
            background: #d4edda;
            color: #155724;
        }

        .pendiente {
            background: #e2e3e5;
            color: #383d41;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Factura </h2>
        <p>Fecha de emisión: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="info">
        <p><strong>Cliente:</strong> {{ $factura->cliente?->nombre ?? 'Sin cliente' }}</p>
        <p><strong>Empleado:</strong> {{ $factura->empleado?->nombre ?? 'Sin empleado' }}</p>
        <p><strong>Fecha:</strong> {{ $factura->fecha }}</p>
        <p><strong>Tipo de Pago:</strong> {{ ucfirst($factura->tipo_pago) }}</p>
        <p><strong>Estado:</strong>
            <span class="badge {{ $factura->estado == 'pagada' ? 'pagada' : 'pendiente' }}">
                {{ strtoupper($factura->estado) }}
            </span>
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factura->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>${{ number_format($detalle->producto->precio_unitario, 2) }}</td>
                    <td>${{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total: ${{ number_format($factura->total, 2) }}</p>

    @if($factura->tipo_pago == 'contado')
        @if($factura->efectivo_recibido)
            <p class="total">Efectivo Recibido: ${{ number_format($factura->efectivo_recibido, 2) }}</p>
            <p class="total" style="color: green;">
                Vuelto: ${{ number_format($factura->efectivo_recibido - $factura->total, 2) }}
            </p>
        @endif

    @elseif($factura->tipo_pago == 'credito')
        @php $abonado = $factura->pagos->sum('monto'); @endphp
        <p class="total">Abono Inicial: ${{ number_format($abonado, 2) }}</p>
        @if($factura->saldo_pendiente > 0)
            <p class="total" style="color: red;">
                Saldo Pendiente: ${{ number_format($factura->saldo_pendiente, 2) }}
            </p>
        @else
            <p class="total" style="color: green;">PAGADA COMPLETAMENTE</p>
        @endif
    @endif
</body>

</html>