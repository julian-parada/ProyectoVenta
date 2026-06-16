@extends('layouts.adminlte')
@section('title', 'Facturas')

@section('main_content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-receipt"></i> Facturas</h2>
        <a href="{{ route('facturas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Factura
        </a>
        <a href="{{ route('facturas.pdf.general') }}" class="btn btn-danger me-2">
            <i class="fas fa-file-pdf"></i> Exportar PDF General
        </a>
        <a href="{{ route('facturas.excel.general') }}" class="btn btn-success me-2">
            <i class="fas fa-file-excel"></i> Exportar Excel General
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
                                <a href="{{ route('facturas.pdf', $factura->id) }}" class="btn btn-sm btn-danger"
                                    target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('facturas.excel', $factura->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-file-excel"></i>
                                </a>

                                <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                {{-- ✅ JavaScript al final --}}
                                @push('js')
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            document.querySelectorAll('.status-toggle').forEach(function (toggle) {
                                                toggle.addEventListener('change', function () {
                                                    if (this.dataset.processing === 'true') return;

                                                    this.dataset.processing = 'true';
                                                    const url = this.dataset.url;
                                                    const self = this;

                                                    fetch(url, {
                                                        method: 'PATCH',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                        }
                                                    })
                                                        .then(res => res.json())
                                                        .then(data => {
                                                            const badge = self.closest('div').querySelector('.badge');

                                                            if (data.status) {
                                                                self.checked = true;
                                                                badge.classList.remove('badge-danger');
                                                                badge.classList.add('badge-success');
                                                                badge.textContent = 'Activo';
                                                            } else {
                                                                self.checked = false;
                                                                badge.classList.remove('badge-success');
                                                                badge.classList.add('badge-danger');
                                                                badge.textContent = 'Inactivo';
                                                            }
                                                        })
                                                        .catch(() => {
                                                            self.checked = !self.checked;
                                                        })
                                                        .finally(() => {
                                                            self.dataset.processing = 'false';
                                                        });
                                                });
                                            });
                                        });
                                        document.querySelectorAll('.btn-eliminar').forEach(function (btn) {
                                            btn.addEventListener('click', function () {
                                                const form = this.closest('form');
                                                Swal.fire({
                                                    title: '¿Estás seguro?',
                                                    text: 'Esta acción no se puede deshacer.',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#d33',
                                                    cancelButtonColor: '#6c757d',
                                                    confirmButtonText: 'Sí, eliminar',
                                                    cancelButtonText: 'Cancelar'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        form.submit();
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                @endpush
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

{{-- ✅ JavaScript al final --}}
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.status-toggle').forEach(function (toggle) {
                toggle.addEventListener('change', function () {
                    if (this.dataset.processing === 'true') return;

                    this.dataset.processing = 'true';
                    const url = this.dataset.url;
                    const self = this;

                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            const badge = self.closest('div').querySelector('.badge');

                            if (data.status) {
                                self.checked = true;
                                badge.classList.remove('badge-danger');
                                badge.classList.add('badge-success');
                                badge.textContent = 'Activo';
                            } else {
                                self.checked = false;
                                badge.classList.remove('badge-success');
                                badge.classList.add('badge-danger');
                                badge.textContent = 'Inactivo';
                            }
                        })
                        .catch(() => {
                            self.checked = !self.checked;
                        })
                        .finally(() => {
                            self.dataset.processing = 'false';
                        });
                });
            });
        });
        document.querySelectorAll('.btn-eliminar').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const form = this.closest('form');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush