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
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Eliminar este producto?')">
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
                            <td colspan="8" class="text-center text-muted">No hay empleados registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection