@extends('layouts.error')

@section('content')
<style>
    .error-404-wrap {
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
    }
    .error-404-card {
        background: var(--color-background-primary, #fff);
        border: 0.5px solid var(--color-border-tertiary, #e0e0e0);
        border-radius: 16px;
        padding: 3rem 2.5rem;
        text-align: center;
        max-width: 480px;
        width: 100%;
    }
    .error-404-number {
        font-size: 96px;
        font-weight: 500;
        color: #378ADD;
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    .error-404-title {
        font-size: 22px;
        font-weight: 500;
        color: var(--color-text-primary, #111);
        margin-bottom: 0.75rem;
    }
    .error-404-desc {
        font-size: 15px;
        color: var(--color-text-secondary, #666);
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    .error-404-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #378ADD;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.65rem 1.5rem;
        font-size: 15px;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.2s;
    }
    .error-404-btn:hover {
        background: #185FA5;
        color: #fff;
        text-decoration: none;
    }
    .error-404-icon {
        font-size: 64px;
        color: #B5D4F4;
        margin-bottom: 1rem;
    }
</style>

<div class="error-404-wrap">
    <div class="error-404-card">
        <div class="error-404-icon">
            <i class="fas fa-map-signs"></i>
        </div>
        <div class="error-404-number">404</div>
        <div class="error-404-title">Página no encontrada</div>
        <p class="error-404-desc">
            La página que estás buscando no existe o fue movida a otra dirección.
        </p>
        <a href="{{ route('home') }}" class="error-404-btn">
            <i class="fas fa-home"></i> Volver al inicio
        </a>
    </div>
</div>
@endsection
