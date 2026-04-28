@extends('layouts.adminlte')
@section('title', 'Editar Empleado')

@section('main_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-pencil"></i> Editar Empleado</h2>
    <a href="{{ route('empleados.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('empleados.update', $empleado->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $empleado->nombre) }}">
                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                           value="{{ old('telefono', $empleado->telefono) }}">
                    @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cargo</label>
                    <input type="text" name="cargo" class="form-control @error('cargo') is-invalid @enderror"
                           value="{{ old('cargo', $empleado->cargo) }}">
                    @error('cargo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Departamento</label>
                    <input type="text" name="departamento" class="form-control @error('departamento') is-invalid @enderror"
                           value="{{ old('departamento', $empleado->departamento) }}">
                    @error('departamento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Salario</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="salario"
                               class="form-control @error('salario') is-invalid @enderror"
                               value="{{ old('salario', $empleado->salario) }}" min="0">
                    </div>
                    @error('salario') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select @error('estado') is-invalid @enderror">
                        <option value="activo" {{ old('estado', $empleado->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ old('estado', $empleado->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save"></i> Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
