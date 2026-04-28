@extends('layouts.adminlte')
@section('title', 'Panel Principal')
@section('page_title', 'Panel Principal')

@section('main_content')

{{-- Tarjetas de resumen --}}
<div class="row">
    <div class="col-md-3">
        <div class="info-box shadow">
            <span class="info-box-icon bg-info"><i class="fas fa-box-open"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Productos</span>
                <span class="info-box-number">{{ \App\Models\Producto::count() }}</span>
                <a href="{{ route('productos.index') }}" class="small">Ver todos →</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow">
            <span class="info-box-icon bg-success"><i class="fas fa-user-tag"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Clientes</span>
                <span class="info-box-number">{{ \App\Models\Cliente::count() }}</span>
                <a href="{{ route('clientes.index') }}" class="small">Ver todos →</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow">
            <span class="info-box-icon bg-warning"><i class="fas fa-receipt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Facturas</span>
                <span class="info-box-number">{{ \App\Models\Factura::count() }}</span>
                <a href="{{ route('facturas.index') }}" class="small">Ver todas →</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow">
            <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Stock Bajo</span>
                <span class="info-box-number">
                    {{ \App\Models\Producto::whereColumn('stock', '<=', 'stock_minimo')->count() }}
                </span>
                <a href="{{ route('productos.index') }}" class="small">Ver productos →</a>
            </div>
        </div>
    </div>
</div>

{{-- Total ventas del día --}}
@php
    $ventasHoy = \App\Models\Factura::whereDate('fecha', today())->sum('total');
    $ventasMes = \App\Models\Factura::whereMonth('fecha', now()->month)->sum('total');
    $productosBajos = \App\Models\Producto::whereColumn('stock', '<=', 'stock_minimo')->get();
@endphp

<div class="row mt-2">
    <div class="col-md-6">
        <div class="card card-navy shadow">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-line"></i> Resumen de Ventas</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <tbody>
                        <tr>
                            <td><i class="fas fa-calendar-day text-info"></i> Ventas de hoy</td>
                            <td class="text-right"><strong>${{ number_format($ventasHoy, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-calendar-alt text-warning"></i> Ventas del mes</td>
                            <td class="text-right"><strong>${{ number_format($ventasMes, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-receipt text-success"></i> Total facturas</td>
                            <td class="text-right"><strong>{{ \App\Models\Factura::count() }}</strong></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-clock text-secondary"></i> Facturas pendientes</td>
                            <td class="text-right">
                                <strong>{{ \App\Models\Factura::where('estado', 'pendiente')->count() }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        @if($productosBajos->count() > 0)
        <div class="card card-warning shadow">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle"></i> Productos con Stock Bajo
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Stock Actual</th>
                            <th>Mínimo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productosBajos as $p)
                        <tr>
                            <td>{{ $p->nombre }}</td>
                            <td><span class="badge badge-danger">{{ $p->stock }}</span></td>
                            <td>{{ $p->stock_minimo }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="card card-success shadow">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-check-circle"></i> Inventario</h3>
            </div>
            <div class="card-body">
                <p class="mb-0"><i class="fas fa-check text-success"></i> Todos los productos tienen stock suficiente.</p>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Últimas facturas --}}
<div class="row mt-2">
    <div class="col-12">
        <div class="card card-navy shadow">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-receipt"></i> Últimas Facturas</h3>
                <div class="card-tools">
                    <a href="{{ route('facturas.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Nueva Factura
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Empleado</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Tipo Pago</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Factura::with('cliente','empleado')->latest()->take(8)->get() as $factura)
                        <tr>
                            <td>{{ $factura->id }}</td>
                            <td>{{ $factura->cliente->nombre }}</td>
                            <td>{{ $factura->empleado->nombre }}</td>
                            <td>{{ $factura->fecha }}</td>
                            <td>${{ number_format($factura->total, 2) }}</td>
                            <td>
                                <span class="badge {{ $factura->tipo_pago == 'contado' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $factura->tipo_pago }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $factura->estado == 'pagada' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $factura->estado }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-xs btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection