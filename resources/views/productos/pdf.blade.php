<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2 {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .activo {
            color: #155724;
        }

        .inactivo {
            color: #721c24;
        }

        .stock-bajo {
            color: #721c24;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Listado de Productos</h2>
    <p>Fecha: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Stock Mínimo</th>
                <th>Precio Unitario</th>
                <th>Status </th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->codigo }}</td>
                    <td class="{{ $producto->stock <= $producto->stock_minimo ? 'stock-bajo' : '' }}">
                        {{ $producto->stock }}
                    </td>
                    <td>{{ $producto->stock_minimo }}</td>
                    <td>${{ number_format($producto->precio_unitario, 2) }}</td>
                    <td>
                        <span class="badge {{ $producto->status == 'activo' ? 'activo' : 'inactivo' }}">
                            {{ strtoupper($producto->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>