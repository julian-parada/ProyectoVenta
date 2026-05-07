@extends('layouts.adminlte')
@section('title', 'Clientes')

@section('main_content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-people"></i> Clientes</h2>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Cliente
        </a>
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
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Eliminar este cliente?')">
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
    $(document).on('change', '.status-toggle', function () {
        const toggle = $(this);
        const url    = toggle.data('url');
        const label  = toggle.siblings('label').find('.badge');

        $.ajax({
            url:  url,
            type: 'PATCH',
            data: { _token: '{{ csrf_token() }}' },
            success: function (res) {
                if (res.status) {
                    label.removeClass('badge-danger').addClass('badge-success').text('Activo');
                } else {
                    label.removeClass('badge-success').addClass('badge-danger').text('Inactivo');
                }
                $(document).Toasts('create', {
                    title:    'Estado actualizado',
                    body:      res.message,
                    autohide:  true,
                    delay:     3000,
                    class:     res.status ? 'bg-success' : 'bg-warning',
                });
            },
            error: function () {
                toggle.prop('checked', !toggle.prop('checked'));
                $(document).Toasts('create', {
                    title:    'Error',
                    body:     'No se pudo cambiar el estado del cliente.',
                    autohide:  true,
                    delay:     3000,
                    class:    'bg-danger',
                });
            }
        });
    });
</script>
@endpush