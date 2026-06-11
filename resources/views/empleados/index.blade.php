@extends('layouts.adminlte')
@section('title', 'Empleados')

@section('main_content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-person-badge"></i> Empleados</h2>
        <a href="{{ route('empleados.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Empleado
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Cargo</th>
                        <th>Departamento</th>
                        <th>Teléfono</th>
                        <th>Salario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empleados as $empleado)
                        <tr>
                            <td>{{ $empleado->id }}</td>
                            <td>{{ $empleado->nombre }}</td>
                            <td>{{ $empleado->cargo }}</td>
                            <td>{{ $empleado->departamento ?? '-' }}</td>
                            <td>{{ $empleado->telefono ?? '-' }}</td>
                            <td>${{ number_format($empleado->salario, 2) }}</td>
                            <td>
                                <span class="badge {{ $empleado->estado == 'activo' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $empleado->estado }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('empleados.destroy', $empleado->id) }}" method="POST"
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No hay empleados registrados.</td>
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