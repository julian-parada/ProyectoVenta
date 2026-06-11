@extends('layouts.adminlte')
@section('title', 'Nuevo Cliente')

@section('main_content')
    <style>
        .form-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .form-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99, 179, 237, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .form-hero::after {
            content: '\f007';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 6rem;
            color: rgba(255, 255, 255, 0.05);
        }

        .form-hero h2 {
            color: #fff;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .form-hero p {
            color: rgba(255, 255, 255, 0.6);
            margin: 0.25rem 0 0;
            font-size: 0.9rem;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 0.5rem 1.25rem;
            transition: all 0.2s;
            backdrop-filter: blur(10px);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .form-card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f0f0;
        }

        .section-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #0f3460;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e8f0fe;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            color: #1f2937;
            transition: all 0.2s;
            background: #fafafa;
        }

        .form-control:focus {
            border-color: #0f3460;
            box-shadow: 0 0 0 3px rgba(15, 52, 96, 0.1);
            background: #fff;
        }

        .input-icon-wrap {
            position: relative;
        }

        .input-icon-wrap .input-icon {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 0.85rem;
            pointer-events: none;
        }

        .input-icon-wrap .form-control {
            padding-left: 2.25rem;
        }

        .btn-submit {
            background: linear-gradient(135deg, #0f3460, #1a5276);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(15, 52, 96, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(15, 52, 96, 0.4);
            color: #fff;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .field-animate {
            animation: slideUp 0.4s ease forwards;
            opacity: 0;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .field-animate:nth-child(1) {
            animation-delay: 0.05s;
        }

        .field-animate:nth-child(2) {
            animation-delay: 0.1s;
        }

        .field-animate:nth-child(3) {
            animation-delay: 0.15s;
        }

        .field-animate:nth-child(4) {
            animation-delay: 0.2s;
        }

        .field-animate:nth-child(5) {
            animation-delay: 0.25s;
        }
    </style>

    <div class="form-hero d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-user-plus mr-2"></i> Nuevo Cliente</h2>
            <p>Completa la información para registrar un nuevo cliente</p>
        </div>
        <a href="{{ route('clientes.index') }}" class="btn btn-back">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <div class="section-title"><i class="fas fa-id-card mr-2"></i>Información personal</div>

            <div class="row g-3">
                <div class="col-md-6 field-animate">
                    <label class="form-label">Nombre completo</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                            placeholder="Ej: Juan Pérez" value="{{ old('nombre') }}">
                    </div>
                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 field-animate">
                    <label class="form-label">N° Identificación</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-fingerprint input-icon"></i>
                        <input type="text" name="n_identificacion"
                            class="form-control @error('n_identificacion') is-invalid @enderror" placeholder="Cédula o NIT"
                            value="{{ old('n_identificacion') }}">
                    </div>
                    @error('n_identificacion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="section-title mt-4"><i class="fas fa-address-book mr-2"></i>Contacto</div>

            <div class="row g-3">
                <div class="col-md-6 field-animate">
                    <label class="form-label">Teléfono</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                            placeholder="Ej: 3001234567" value="{{ old('telefono') }}">
                    </div>
                    @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 field-animate">
                    <label class="form-label">Email</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="correo@ejemplo.com" value="{{ old('email') }}">
                    </div>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12 field-animate">
                    <label class="form-label">Dirección</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-map-marker-alt input-icon"></i>
                        <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                            placeholder="Calle, barrio, ciudad" value="{{ old('direccion') }}">
                    </div>
                    @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save mr-2"></i> Guardar Cliente
                </button>
                <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary"
                    style="border-radius:12px; padding: 0.75rem 1.5rem;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection