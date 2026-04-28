@extends('layouts.adminlte')
@section('title', 'Facturas')

@section('main_content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-receipt"></i> Facturas</h2>
        <a href="{{ route('facturas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Factura
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Empleado</th>
                        <th>Fecha</th>
                        <th>Tipo Pago</th>
                        <th>Total</th>
                        <th>Saldo Pendiente</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facturas as $factura)
                        <tr>
                            <td>{{ $factura->id }}</td>
                            <td>{{ $factura->cliente->nombre }}</td>
                            <td>{{ $factura->empleado->nombre }}</td>
                            <td>{{ $factura->fecha }}</td>
                            <td>
                                <span
                                    class="badge {{ $factura->tipo_pago == 'contado' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $factura->tipo_pago }}
                                </span>
                            </td>
                            <td>${{ number_format($factura->total, 2) }}</td>
                            <td>${{ number_format($factura->saldo_pendiente, 2) }}</td>
                            <td>
                                <span class="badge {{ $factura->estado == 'pagada' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $factura->estado }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Eliminar esta factura?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No hay facturas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection