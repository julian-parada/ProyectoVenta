@extends('layouts.adminlte')
@section('title', 'Cambiar Contraseña')

@section('main_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="fas fa-key"></i> Cambiar Contraseña</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0"><i class="fas fa-lock"></i> Nueva contraseña</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update-password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Contraseña actual</label>
                        <input type="password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               placeholder="Ingresa tu contraseña actual" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-key"></i> Nueva contraseña</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Mínimo 8 caracteres" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-key"></i> Confirmar nueva contraseña</label>
                        <input type="password" name="password_confirmation"
                               class="form-control"
                               placeholder="Repite la nueva contraseña" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="fas fa-save"></i> Cambiar contraseña
                        </button>
                        <a href="{{ route('profile.edit') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left"></i> Volver al perfil
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsections