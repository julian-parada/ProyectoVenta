@extends('layouts.adminlte')
@section('title', 'Nueva Factura')
@section('page_title', 'Nueva Factura')

@section('main_content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-plus-circle"></i> Nueva Factura</h2>
        <a href="{{ route('facturas.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('facturas.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Cliente</label>
                        <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror">
                            <option value="">-- Seleccionar --</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Método de Pago</label>
                        <select name="metodopago_id" class="form-select @error('metodopago_id') is-invalid @enderror">
                            <option value="">-- Seleccionar --</option>
                            @foreach($metodos as $metodo)
                                <option value="{{ $metodo->id }}" {{ old('metodopago_id') == $metodo->id ? 'selected' : '' }}>
                                    {{ $metodo->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('metodopago_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Empleado</label>
                        <select name="empleado_id" class="form-select @error('empleado_id') is-invalid @enderror">
                            <option value="">-- Seleccionar --</option>
                            @foreach($empleados as $empleado)
                                <option value="{{ $empleado->id }}" {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                                    {{ $empleado->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('empleado_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                            value="{{ old('fecha', date('Y-m-d')) }}">
                        @error('fecha') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>



                    {{-- Campo abono inicial solo visible en crédito --}}
                    <div class="col-md-2">
                        <label class="form-label">Tipo de Pago</label>
                        <select name="tipo_pago" id="tipo_pago" class="form-select @error('tipo_pago') is-invalid @enderror"
                            onchange="togglePago()">
                            <option value="contado">Contado</option>
                            <option value="credito">Crédito</option>
                        </select>
                        @error('tipo_pago') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Contado: efectivo recibido --}}
                    <div class="col-md-3" id="campo_efectivo">
                        <label class="form-label">Efectivo Recibido</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" name="efectivo_recibido" id="efectivo_recibido"
                                class="form-control" min="0" value="{{ old('efectivo_recibido', 0) }}"
                                oninput="calcularVuelto()">
                        </div>
                        <small class="text-muted">Vuelto: $<span id="vuelto_mostrar"
                                class="text-success font-weight-bold">0.00</span></small>
                    </div>

                    {{-- Crédito: abono inicial --}}
                    <div class="col-md-3" id="campo_abono" style="display:none;">
                        <label class="form-label">Abono Inicial</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" name="abono_inicial" id="abono_inicial" class="form-control"
                                min="0" value="{{ old('abono_inicial', 0) }}" oninput="calcularSaldo()">
                        </div>
                        <small class="text-muted">Saldo pendiente: $<span id="saldo_mostrar"
                                class="text-danger font-weight-bold">0.00</span></small>
                    </div>
                </div>

                {{-- Tabla de productos --}}
                <h5 class="mt-4">Productos</h5>
                <table class="table table-bordered" id="tabla-productos">
                    <thead class="table-secondary">
                        <tr>
                            <th>Producto</th>
                            <th>Precio Unit.</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="filas-productos">
                        <tr id="fila-0">
                            <td>
                                <select name="productos[0][id]" class="form-select producto-select"
                                    onchange="actualizarPrecio(0)">
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
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarFila()">
                                    <i class="bi bi-plus"></i> Agregar producto
                                </button>
                            </td>
                        </tr>
                        <tr class="table-dark">
                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                            <td colspan="2"><strong id="total-general">$0.00</strong></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar Factura
                    </button>
                </div>
            </form>
        </div>
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
            const totalTexto = document.getElementById('total-general').textContent.replace('$', '');
            const total = parseFloat(totalTexto) || 0;
            const efectivo = parseFloat(document.getElementById('efectivo_recibido').value) || 0;
            const vuelto = efectivo - total;

            const span = document.getElementById('vuelto_mostrar');

            if (efectivo > 0 && vuelto < 0) {
                span.textContent = '0.00 ⚠️ Falta: $' + Math.abs(vuelto).toFixed(2);
                span.className = 'text-danger font-weight-bold';
            } else if (vuelto > 0) {
                span.textContent = vuelto.toFixed(2);
                span.className = 'text-success font-weight-bold';
            } else {
                span.textContent = '0.00';
                span.className = 'text-muted';
            }
        }

        function calcularSaldo() {
            const totalTexto = document.getElementById('total-general').textContent.replace('$', '');
            const total = parseFloat(totalTexto) || 0;
            const abono = parseFloat(document.getElementById('abono_inicial').value) || 0;
            const saldo = Math.max(0, total - abono);
            document.getElementById('saldo_mostrar').textContent = saldo.toFixed(2);
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
            document.querySelectorAll('.subtotal-input').forEach(input => {
                total += parseFloat(input.value) || 0;
            });
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
                                <td>
                                    <select name="productos[${index}][id]" class="form-select" onchange="actualizarPrecio(${index})">
                                        <option value="">-- Seleccionar --</option>
                                        ${opciones}
                                    </select>
                                </td>
                                <td><input type="text" class="form-control precio-unit" id="precio-${index}" readonly value="0.00"></td>
                                <td><input type="number" name="productos[${index}][cantidad]" class="form-control cantidad-input" id="cantidad-${index}" min="1" value="1" onchange="calcularSubtotal(${index})"></td>
                                <td><input type="text" class="form-control subtotal-input" id="subtotal-${index}" readonly value="0.00"></td>
                                <td><button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(${index})"><i class="fas fa-trash"></i></button></td>
                            </tr>`;
            document.getElementById('filas-productos').insertAdjacentHTML('beforeend', fila);
        }

        function eliminarFila(index) {
            document.getElementById(`fila-${index}`).remove();
            calcularTotal();
        }
        // Restaurar productos si hubo error
        window.onload = function () {
            const oldProductos = @json(old('productos', []));
            if (oldProductos.length > 0) {
                // Limpiar fila inicial
                document.getElementById('filas-productos').innerHTML = '';
                filaCount = 0;

                oldProductos.forEach(function (item, index) {
                    if (!item.id) return;

                    const opciones = Object.values(productos).map(p =>
                        `<option value="${p.id}" ${p.id == item.id ? 'selected' : ''} data-precio="${p.precio_unitario}">
                                    ${p.nombre} (${p.codigo})
                                </option>`
                    ).join('');

                    const precio = productos[item.id] ? productos[item.id].precio_unitario : 0;
                    const subtotal = precio * (item.cantidad || 1);

                    const fila = `
                            <tr id="fila-${index}">
                                <td>
                                    <select name="productos[${index}][id]" class="form-select" onchange="actualizarPrecio(${index})">
                                        <option value="">-- Seleccionar --</option>
                                        ${opciones}
                                    </select>
                                </td>
                                <td><input type="text" class="form-control precio-unit" id="precio-${index}" readonly value="${parseFloat(precio).toFixed(2)}"></td>
                                <td><input type="number" name="productos[${index}][cantidad]" class="form-control cantidad-input" id="cantidad-${index}" min="1" value="${item.cantidad || 1}" onchange="calcularSubtotal(${index})"></td>
                                <td><input type="text" class="form-control subtotal-input" id="subtotal-${index}" readonly value="${subtotal.toFixed(2)}"></td>
                                <td><button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(${index})"><i class="fas fa-trash"></i></button></td>
                            </tr>`;

                    document.getElementById('filas-productos').insertAdjacentHTML('beforeend', fila);
                    filaCount = index + 1;
                });

                calcularTotal();
            }

            // Restaurar tipo de pago
            const tipoPago = document.getElementById('tipo_pago').value;
            togglePago();
        };
    </script>
@endsection