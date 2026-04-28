@extends('layouts.adminlte')
@section('title', 'Métodos de Pago')

@section('main_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-credit-card"></i> Métodos de Pago</h2>
    <a href="{{ route('metodopagos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Método
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($metodopagos as $metodo)
                <tr>
                    <td>{{ $metodo->id }}</td>
                    <td>{{ $metodo->nombre }}</td>
                    <td>{{ $metodo->descripcion ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $metodo->estado == 'activo' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $metodo->estado }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('metodopagos.edit', $metodo->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('metodopagos.destroy', $metodo->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este método?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No hay métodos de pago registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
