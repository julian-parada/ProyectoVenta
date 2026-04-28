@extends('layouts.adminlte')
@section('title', 'Editar Factura')

@section('main_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-pencil"></i> Editar Factura #{{ $factura->id }}</h2>
    <a href="{{ route('facturas.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('facturas.update', $factura->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Cliente</label>
                    <input type="text" class="form-control" value="{{ $factura->cliente->nombre }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Empleado</label>
                    <input type="text" class="form-control" value="{{ $factura->empleado->nombre }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="text" class="form-control" value="{{ $factura->fecha }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipo de Pago</label>
                    <select name="tipo_pago" class="form-select">
                        <option value="contado" {{ $factura->tipo_pago == 'contado' ? 'selected' : '' }}>Contado</option>
                        <option value="credito" {{ $factura->tipo_pago == 'credito' ? 'selected' : '' }}>Crédito</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="pendiente" {{ $factura->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="pagada" {{ $factura->estado == 'pagada' ? 'selected' : '' }}>Pagada</option>
                        <option value="anulada" {{ $factura->estado == 'anulada' ? 'selected' : '' }}>Anulada</option>
                    </select>
                </div>
            </div>

            <h5 class="mt-4">Productos</h5>
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->nombre }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>${{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <td colspan="2" class="text-end"><strong>Total</strong></td>
                        <td><strong>${{ number_format($factura->total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
