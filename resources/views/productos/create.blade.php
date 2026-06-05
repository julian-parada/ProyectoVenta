@extends('layouts.adminlte')
@section('title', 'Nuevo Producto')

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

        .form-hero::after {
            content: '\f290';
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
            transition: all 0.2s;
            background: #fafafa;
        }

        .form-control:focus {
            border-color: #0f3460;
            box-shadow: 0 0 0 3px rgba(15, 52, 96, 0.1);
            background: #fff;
        }

        .input-group-text {
            border: 1.5px solid #e5e7eb;
            border-right: none;
            border-radius: 10px 0 0 10px;
            background: #f3f4f6;
            color: #6b7280;
            font-weight: 600;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
            border-left: none;
        }

        .stat-card {
            background: linear-gradient(135deg, #f8faff, #eef2ff);
            border: 1.5px solid #e0e7ff;
            border-radius: 14px;
            padding: 1.25rem;
            text-align: center;
            transition: all 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 52, 96, 0.1);
        }

        .stat-card .stat-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .stat-card label {
            display: block;
        }

        .btn-submit {
            background: linear-gradient(135deg, #0f3460, #1a5276);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(15, 52, 96, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(15, 52, 96, 0.4);
            color: #fff;
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
            <h2><i class="fas fa-box mr-2"></i> Nuevo Producto</h2>
            <p>Completa la información para registrar un nuevo producto</p>
        </div>
        <a href="{{ route('productos.index') }}" class="btn btn-back">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            <div class="section-title"><i class="fas fa-tag mr-2"></i>Identificación del producto</div>

            <div class="row g-3">
                <div class="col-md-6 field-animate">
                    <label class="form-label">Nombre del producto</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                        placeholder="Ej: Arroz Diana 500g" value="{{ old('nombre') }}">
                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 field-animate">
                    <label class="form-label">Código</label>
                    <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror"
                        placeholder="Ej: PROD-001" value="{{ old('codigo') }}">
                    @error('codigo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="section-title mt-4"><i class="fas fa-cubes mr-2"></i>Inventario y precio</div>

            <div class="row g-3">
                <div class="col-md-4 field-animate">
                    <div class="stat-card">
                        <div class="stat-icon text-success">📦</div>
                        <label class="form-label">Stock inicial</label>
                        <input type="number" name="stock"
                            class="form-control text-center @error('stock') is-invalid @enderror"
                            value="{{ old('stock', 0) }}" min="0">
                        @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-4 field-animate">
                    <div class="stat-card">
                        <div class="stat-icon text-warning">⚠️</div>
                        <label class="form-label">Stock mínimo</label>
                        <input type="number" name="stock_minimo"
                            class="form-control text-center @error('stock_minimo') is-invalid @enderror"
                            value="{{ old('stock_minimo', 0) }}" min="0">
                        @error('stock_minimo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-4 field-animate">
                    <div class="stat-card">
                        <div class="stat-icon text-primary">💰</div>
                        <label class="form-label">Precio unitario</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" name="precio_unitario"
                                class="form-control text-center @error('precio_unitario') is-invalid @enderror"
                                value="{{ old('precio_unitario') }}" min="0" placeholder="0.00">
                        </div>
                        @error('precio_unitario') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-save mr-2"></i> Guardar Producto
                </button>
                <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary"
                    style="border-radius:12px; padding: 0.75rem 1.5rem;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection