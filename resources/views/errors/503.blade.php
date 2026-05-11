@extends('layouts.error')

@section('content')
<style>
    .error-wrap {
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
    }
    .error-card {
        background: var(--color-background-primary, #fff);
        border: 0.5px solid var(--color-border-tertiary, #e0e0e0);
        border-radius: 16px;
        padding: 3rem 2.5rem;
        text-align: center;
        max-width: 480px;
        width: 100%;
    }
    .error-icon { font-size: 64px; margin-bottom: 1rem; }
    .error-number { font-size: 96px; font-weight: 500; line-height: 1; margin-bottom: 0.5rem; }
    .error-title { font-size: 22px; font-weight: 500; color: var(--color-text-primary, #111); margin-bottom: 0.75rem; }
    .error-desc { font-size: 15px; color: var(--color-text-secondary, #666); margin-bottom: 2rem; line-height: 1.6; }
    .error-btn {
        display: inline-flex; align-items: center; gap: 8px;
        color: #fff; border: none; border-radius: 8px;
        padding: 0.65rem 1.5rem; font-size: 15px; font-weight: 500;
        text-decoration: none; transition: background 0.2s;
    }
    .error-btn:hover { color: #fff; text-decoration: none; filter: brightness(0.9); }
</style>

<div class="error-wrap">
    <div class="error-card">
        <div class="error-icon" style="color: #9FE1CB;">
            <i class="fas fa-tools"></i>
        </div>
        <div class="error-number" style="color: #0F6E56;">503</div>
        <div class="error-title">Servicio no disponible</div>
        <p class="error-desc">
            El servicio está temporalmente en mantenimiento. Vuelve a intentarlo en unos minutos.
        </p>
        <a href="{{ route('home') }}" class="error-btn" style="background: #0F6E56;">
            <i class="fas fa-home"></i> Volver al inicio
        </a>
    </div>
</div>
@endsection