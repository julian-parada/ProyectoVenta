@extends('layouts.adminlte')
@section('title', 'Factura #' . $factura->id)
@section('page_title', 'Detalle Factura #' . $factura->id)

@section('main_content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('facturas.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-pencil-alt"></i> Editar
        </a>
    </div>

    <div class="row">
        {{-- Info factura --}}
        <div class="col-md-5">
            <div class="card card-navy shadow">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-receipt"></i> Factura #{{ $factura->id }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td><strong>Cliente</strong></td>
                            <td>{{ $factura->cliente->nombre }}</td>
                        </tr>
                        <tr>
                            <td><strong>Empleado</strong></td>
                            <td>{{ $factura->empleado->nombre }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha</strong></td>
                            <td>{{ $factura->fecha }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tipo Pago</strong></td>
                            <td>
                                <span
                                    class="badge {{ $factura->tipo_pago == 'contado' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $factura->tipo_pago }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong>${{ number_format($factura->total, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Saldo Pendiente</strong></td>
                            <td>
                                <strong class="{{ $factura->saldo_pendiente > 0 ? 'text-danger' : 'text-success' }}">
                                    ${{ number_format($factura->saldo_pendiente, 2) }}
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Estado</strong></td>
                            <td>
                                <span
                                    class="badge {{ $factura->estado == 'pagada' ? 'badge-success' : 'badge-secondary' }} badge-lg"
                                    style="font-size:1em">
                                    @if($factura->estado == 'pagada')
                                        <i class="fas fa-check-circle"></i> PAGADA
                                    @else
                                        <i class="fas fa-clock"></i> PENDIENTE
                                    @endif
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Historial de pagos --}}
            @if($factura->pagos->count() > 0)
                <div class="card card-success shadow mt-3">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-money-bill-wave"></i> Historial de Pagos</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Método</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($factura->pagos as $pago)
                                    <tr>
                                        <td>{{ $pago->fecha_pago }}</td>
                                        <td>{{ $factura->tipo_pago }}</td>
                                        <td class="text-success"><strong>${{ number_format($pago->monto, 2) }}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Formulario de abono --}}
            @if($factura->estado != 'pagada')
                    <div class="card card-warning shadow mt-3">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-hand-holding-usd"></i> Registrar Abono</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('facturas.abonar', $factura->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Método de Pago</label>
                                    <select name="metodopago_id" class="form-control" required>
                                        <option value="">-- Seleccionar --</option>
                                        @foreach(\App\Models\MetodoPago::where('estado', 'activo')->get() as $metodo)
                                            <option value="{{ $metodo->id }}">{{ $metodo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($factura->estado != 'pagada')
                                    <div class="card card-warning shadow mt-3">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-hand-holding-usd"></i> Registrar Abono</h3>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('facturas.abonar', $factura->id) }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Monto a Pagar</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input type="number" step="0.01" name="monto" id="monto_abono"
                                                            class="form-control" min="1"
                                                            placeholder="Saldo: ${{ number_format($factura->saldo_pendiente, 2) }}"
                                                            oninput="calcularVueltoAbono({{ $factura->saldo_pendiente }})">
                                                    </div>
                                                    <small class="text-muted">
                                                        Vuelto: $<span id="vuelto_abono"
                                                            class="text-success font-weight-bold">0.00</span>
                                                    </small>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="submit" class="btn btn-success btn-block"
                                                            onclick="document.getElementById('monto_abono').value='{{ $factura->saldo_pendiente }}'">
                                                            <i class="fas fa-check-double"></i> Pagar Todo
                                                            (${{ number_format($factura->saldo_pendiente, 2) }})
                                                        </button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button type="submit" class="btn btn-primary btn-block">
                                                            <i class="fas fa-hand-holding-usd"></i> Abonar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <script>
                                        function calcularVueltoAbono(saldo) {
                                            const monto = parseFloat(document.getElementById('monto_abono').value) || 0;
                                            const vuelto = Math.max(0, monto - saldo);
                                            document.getElementById('vuelto_abono').textContent = vuelto.toFixed(2);
                                        }
                                    </script>
                                @endif
                                <label>Monto a Abonar</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" step="0.01" name="monto" class="form-control"
                                        max="{{ $factura->saldo_pendiente }}"
                                        placeholder="Máx: ${{ number_format($factura->saldo_pendiente, 2) }}" required>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-success btn-block"
                                    onclick="this.form.monto.value='{{ $factura->saldo_pendiente }}'">
                                    <i class="fas fa-check-double"></i> Pagar Todo
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-hand-holding-usd"></i> Abonar
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            @endif
    </div>

    {{-- Productos --}}
    <div class="col-md-7">
        <div class="card card-navy shadow">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-box-open"></i> Productos</h3>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="thead-dark">
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
                    <tfoot>
                        <tr class="thead-dark">
                            <td colspan="3" class="text-right"><strong>Total</strong></td>
                            <td><strong>${{ number_format($factura->total, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection