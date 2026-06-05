@extends('layouts.adminlte')
@section('title', 'Nueva Factura')
@section('page_title', 'Nueva Factura')

@section('main_content')
    <style>
        .form-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .form-hero::after {
            content: '\f570';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 6rem;
            color: rgba(255, 255, 255, 0.05);
        }

        .form-hero h2 {
            color: #fff;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .form-hero p {
            color: rgba(255, 255, 255, 0.6);
            margin: 0.25rem 0 0;
            font-size: 0.9rem;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 0.5rem 1.25rem;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .form-card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f0f0;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #0f3460;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e8f0fe;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control,
        .form-select {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s;
            background: #fafafa;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0f3460;
            box-shadow: 0 0 0 3px rgba(15, 52, 96, 0.1);
            background: #fff;
        }

        .input-group-text {
            border: 1.5px solid #e5e7eb;
            border-right: none;
            border-radius: 10px 0 0 10px;
            background: #f3f4f6;
            color: #6b7280;
            font-weight: 600;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
            border-left: none;
        }

        .pago-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s;
        }

        .pago-badge.contado {
            background: #ecfdf5;
            color: #065f46;
            border-color: #d1fae5;
        }

        .pago-badge.credito {
            background: #fff7ed;
            color: #92400e;
            border-color: #fed7aa;
        }

        .products-table {
            border-radius: 14px;
            overflow: hidden;
            border: 1.5px solid #e5e7eb;
        }

        .products-table thead th {
            background: linear-gradient(135deg, #1a1a2e, #0f3460);
            color: #fff;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.9rem 1rem;
            border: none;
        }

        .products-table tbody tr {
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.15s;
        }

        .products-table tbody tr:hover {
            background: #f8faff;
        }

        .products-table tbody td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }

        .products-table tfoot td {
            padding: 0.75rem 1rem;
            background: #f8faff;
        }

        .total-box {
            background: linear-gradient(135deg, #0f3460, #1a5276);
            color: #fff;
            border-radius: 14px;
            padding: 1.25rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .total-box .total-label {
            font-size: 0.85rem;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .total-box .total-amount {
            font-size: 1.75rem;
            font-weight: 700;
        }

        .btn-add-product {
            background: #eef2ff;
            color: #0f3460;
            border: 1.5px dashed #c7d2fe;
            border-radius: 10px;
            padding: 0.5rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-add-product:hover {
            background: #e0e7ff;
            border-color: #818cf8;
            color: #0f3460;
        }

        .btn-submit {
            background: linear-gradient(135deg, #0f3460, #1a5276);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(15, 52, 96, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(15, 52, 96, 0.4);
            color: #fff;
        }

        .vuelto-info {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.82rem;
            color: #065f46;
            margin-top: 0.4rem;
        }

        .saldo-info {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.82rem;
            color: #92400e;
            margin-top: 0.4rem;
        }
    </style>

    <div class="form-hero d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-file-invoice-dollar mr-2"></i> Nueva Factura</h2>
            <p>Registra una nueva venta o transacción</p>
        </div>
        <a href="{{ route('facturas.index') }}" class="btn btn-back">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('facturas.store') }}" method="POST" id="factura-form">
            @csrf

            <div class="section-title"><i class="fas fa-info-circle mr-2"></i>Información general</div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label"><i class="fas fa-user mr-1"></i> Cliente</label>
                    <select name="cliente_id" class="form-control select2 @error('cliente_id') is-invalid @enderror"
                        style="width:100%">
                        <option value="">-- Seleccionar cliente --</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('cliente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <input type="hidden" name="empleado_id" value="1">

                <div class="col-md-2">
                    <label class="form-label"><i class="fas fa-calendar mr-1"></i> Fecha</label>
                    <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                        value="{{ old('fecha', date('Y-m-d')) }}">
                    @error('fecha') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-2">
                    <label class="form-label"><i class="fas fa-credit-card mr-1"></i> Tipo de Pago</label>
                    <select name="tipo_pago" id="tipo_pago" class="form-select @error('tipo_pago') is-invalid @enderror"
                        onchange="togglePago()">
                        <option value="contado">Contado</option>
                        <option value="credito">Crédito</option>
                    </select>
                    @error('tipo_pago') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3" id="campo_efectivo">
                    <label class="form-label"><i class="fas fa-money-bill mr-1"></i> Efectivo Recibido</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="efectivo_recibido" id="efectivo_recibido"
                            class="form-control" min="0" value="{{ old('efectivo_recibido', 0) }}"
                            oninput="calcularVuelto()">
                    </div>
                    <div class="vuelto-info">
                        💵 Vuelto: $<span id="vuelto_mostrar" class="fw-bold">0.00</span>
                    </div>
                </div>

                <div class="col-md-3" id="campo_abono" style="display:none;">
                    <label class="form-label"><i class="fas fa-hand-holding-usd mr-1"></i> Abono Inicial</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="abono_inicial" id="abono_inicial" class="form-control"
                            min="0" value="{{ old('abono_inicial', 0) }}" oninput="calcularSaldo()">
                    </div>
                    <div class="saldo-info">
                        ⏳ Saldo: $<span id="saldo_mostrar" class="fw-bold">0.00</span>
                    </div>
                </div>
            </div>

            <div class="section-title mt-4"><i class="fas fa-boxes mr-2"></i>Productos</div>

            <div class="products-table mb-3">
                <table class="table mb-0" id="tabla-productos">
                    <thead>
                        <tr>
                            <th style="width:40%">Producto</th>
                            <th style="width:15%">Precio Unit.</th>
                            <th style="width:15%">Cantidad</th>
                            <th style="width:20%">Subtotal</th>
                            <th style="width:10%"></th>
                        </tr>
                    </thead>
                    <tbody id="filas-productos">
                        <tr id="fila-0">
                            <td>
                                <select name="productos[0][id]" class="form-control producto-select" id="producto-select-0"
                                    style="width:100%">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_unitario }}">
                                            {{ $producto->nombre }} ({{ $producto->codigo }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" class="form-control precio-unit" id="precio-0" readonly value="0.00">
                            </td>
                            <td><input type="number" name="productos[0][cantidad]" class="form-control cantidad-input"
                                    id="cantidad-0" min="1" value="1" onchange="calcularSubtotal(0)"></td>
                            <td><input type="text" class="form-control subtotal-input" id="subtotal-0" readonly
                                    value="0.00"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(0)"
                                    style="border-radius:8px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <button type="button" class="btn btn-add-product" onclick="agregarFila()">
                                    <i class="fas fa-plus mr-1"></i> Agregar producto
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="total-box mb-4">
                <div>
                    <div class="total-label">Total a pagar</div>
                    <div class="total-amount" id="total-general">$0.00</div>
                </div>
                <i class="fas fa-receipt" style="font-size:2rem; opacity:0.3;"></i>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save mr-2"></i> Guardar Factura
                </button>
                <a href="{{ route('facturas.index') }}" class="btn btn-outline-secondary"
                    style="border-radius:12px; padding: 0.75rem 1.5rem;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        const productos = @json($productos->keyBy('id'));
        let filaCount = 1;

        function togglePago() {
            const tipo = document.getElementById('tipo_pago').value;
            document.getElementById('campo_efectivo').style.display = tipo === 'contado' ? 'block' : 'none';
            document.getElementById('campo_abono').style.display = tipo === 'credito' ? 'block' : 'none';
            calcularTotal();
        }

        function calcularVuelto() {
            const total = parseFloat(document.getElementById('total-general').textContent.replace('$', '')) || 0;
            const efectivo = parseFloat(document.getElementById('efectivo_recibido').value) || 0;
            const vuelto = efectivo - total;
            const span = document.getElementById('vuelto_mostrar');
            if (efectivo > 0 && vuelto < 0) {
                span.textContent = '0.00 ⚠️ Falta: $' + Math.abs(vuelto).toFixed(2);
            } else {
                span.textContent = Math.max(0, vuelto).toFixed(2);
            }
        }

        function calcularSaldo() {
            const total = parseFloat(document.getElementById('total-general').textContent.replace('$', '')) || 0;
            const abono = parseFloat(document.getElementById('abono_inicial').value) || 0;
            document.getElementById('saldo_mostrar').textContent = Math.max(0, total - abono).toFixed(2);
        }

        function actualizarPrecio(index) {
            const select = document.querySelector(`select[name="productos[${index}][id]"]`);
            const productoId = select.value;
            const precio = productoId && productos[productoId] ? productos[productoId].precio_unitario : 0;
            document.getElementById(`precio-${index}`).value = parseFloat(precio).toFixed(2);
            calcularSubtotal(index);
        }

        function calcularSubtotal(index) {
            const precio = parseFloat(document.getElementById(`precio-${index}`).value) || 0;
            const cantidad = parseInt(document.getElementById(`cantidad-${index}`).value) || 0;
            document.getElementById(`subtotal-${index}`).value = (precio * cantidad).toFixed(2);
            calcularTotal();
        }

        function calcularTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal-input').forEach(i => total += parseFloat(i.value) || 0);
            document.getElementById('total-general').textContent = '$' + total.toFixed(2);
            calcularVuelto();
            calcularSaldo();
        }

        function agregarFila() {
            const index = filaCount++;
            const opciones = Object.values(productos).map(p =>
                `<option value="${p.id}" data-precio="${p.precio_unitario}">${p.nombre} (${p.codigo})</option>`
            ).join('');

            const fila = `
            <tr id="fila-${index}">
                <td><select name="productos[${index}][id]" class="form-control producto-select" id="producto-select-${index}" style="width:100%">
                    <option value="">-- Seleccionar --</option>${opciones}</select></td>
                <td><input type="text" class="form-control precio-unit" id="precio-${index}" readonly value="0.00"></td>
                <td><input type="number" name="productos[${index}][cantidad]" class="form-control cantidad-input" id="cantidad-${index}" min="1" value="1" onchange="calcularSubtotal(${index})"></td>
                <td><input type="text" class="form-control subtotal-input" id="subtotal-${index}" readonly value="0.00"></td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(${index})" style="border-radius:8px;"><i class="fas fa-trash"></i></button></td>
            </tr>`;

            document.getElementById('filas-productos').insertAdjacentHTML('beforeend', fila);
            $(`#producto-select-${index}`).select2({ theme: 'default', placeholder: '-- Seleccionar --', allowClear: true })
                .on('select2:select select2:clear', () => actualizarPrecio(index));
        }

        function eliminarFila(index) {
            document.getElementById(`fila-${index}`).remove();
            calcularTotal();
        }

        window.addEventListener('load', function () {
            if (typeof $ !== 'undefined') {
                $('.select2').select2({ theme: 'default', placeholder: '-- Seleccionar --', allowClear: true });
                $('#producto-select-0').select2({ theme: 'default', placeholder: '-- Seleccionar --', allowClear: true })
                    .on('select2:select select2:clear', () => actualizarPrecio(0));
            }
            togglePago();
        });
    </script>
@endsection