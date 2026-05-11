@extends('layouts.adminlte')
@section('title', 'Mi Perfil')

@section('main_content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="fas fa-user-circle"></i> Mi Perfil</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm text-center p-4">
            @php
                $fotoPath = auth()->user()->foto ? public_path(auth()->user()->foto) : null;
            @endphp
            @if(auth()->user()->foto && file_exists(public_path(auth()->user()->foto)))
                <img src="{{ asset(auth()->user()->foto) }}"
                     class="img-circle elevation-2 mb-3"
                     style="width:120px; height:120px; object-fit:cover;">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D6EFD&color=fff&size=120"
                     class="img-circle elevation-2 mb-3"
                     style="width:120px; height:120px;">
            @endif
            <h5 class="font-weight-bold">{{ auth()->user()->name }}</h5>
            <p class="text-muted">{{ auth()->user()->email }}</p>
            <a href="{{ route('profile.change-password') }}" class="btn btn-outline-warning btn-sm mt-2">
                <i class="fas fa-key"></i> Cambiar contraseña
            </a>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-edit"></i> Editar información</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Nombre</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-camera"></i> Foto de perfil</label>
                        <input type="file" name="foto" class="form-control-file @error('foto') is-invalid @enderror"
                               accept="image/*">
                        <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG. Máximo 2MB.</small>
                        @error('foto') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar cambios
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsectionss