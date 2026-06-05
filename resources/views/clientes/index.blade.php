@extends('layouts.adminlte')
@section('title', 'Clientes')

@section('main_content')
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-people"></i> Clientes</h2>
    <div>
        <a href="{{ route('clientes.pdf') }}" class="btn btn-danger btn-sm" target="_blank">
            <i class="fas fa-file-pdf"></i> PDF
        </a>
        <a href="{{ route('clientes.excel') }}" class="btn btn-success btn-sm">
            <i class="fas fa-file-excel"></i> Excel
        </a>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Cliente
        </a>
    </div>
</div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Identificación</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Estado</th>   {{-- ✅ columna nueva --}}
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->n_identificacion }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->direccion ?? '-' }}</td>

                            {{-- ✅ Toggle corregido con $cliente --}}
                            <td class="text-center">
                                <div class="custom-control custom-switch">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input status-toggle"
                                        id="status-{{ $cliente->id }}"
                                        data-url="{{ route('clientes.toggle-status', $cliente) }}"
                                        {{ $cliente->status ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="status-{{ $cliente->id }}">
                                        <span class="badge {{ $cliente->status ? 'badge-success' : 'badge-danger' }}">
                                            {{ $cliente->status ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </label>
                                </div>
                            </td>

                            <td>
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                               <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline delete-form">
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
                            <td colspan="8" class="text-center text-muted">No hay clientes registrados.</td>
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
        document.querySelectorAll('.status-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function () {
                if (this.dataset.processing === 'true') return;
                
                this.dataset.processing = 'true';
                const url  = this.dataset.url;
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