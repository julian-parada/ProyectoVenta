<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte General de Facturas</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 20px;
        }

        h2 {
            text-align: center;
        }

        p {
            text-align: right;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Reporte General de Facturas</h2>
    <p>Fecha: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Empleado</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Efectivo</th>
                <th>Vuelto</th>
                <th>Saldo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($facturas as $factura)
                <tr>
                    <td>{{ $factura->id }}</td>
                    <td>{{ $factura->cliente?->nombre ?? 'Sin cliente' }}</td>
                    <td>{{ $factura->empleado?->nombre ?? 'Sin empleado' }}</td>
                    <td>{{ $factura->fecha }}</td>
                    <td>${{ number_format($factura->total, 0, ',', '.') }}</td>
                    <td>${{ number_format($factura->efectivo_recibido ?? 0, 0, ',', '.') }}</td>
                    <td>${{ number_format($factura->vuelto ?? 0, 0, ',', '.') }}</td>
                    <td>${{ number_format($factura->saldo_pendiente ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $factura->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>