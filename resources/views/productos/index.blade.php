@extends('layouts.adminlte')
@section('title', 'Productos')

@section('main_content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-box-seam"></i> Productos</h2>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Stock</th>
                        <th>Stock Mínimo</th>
                        <th>Precio Unitario</th>
                        <th>Estado</th>   {{-- ✅ columna nueva --}}
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td><span class="badge bg-secondary">{{ $producto->codigo }}</span></td>
                            <td>
                                {{-- ✅ Solo una versión del stock --}}
                                @if($producto->stock <= $producto->stock_minimo)
                                    <span class="badge bg-danger">{{ $producto->stock }}</span>
                                    <i class="bi bi-exclamation-triangle-fill text-warning" title="Stock bajo el mínimo"></i>
                                @elseif($producto->stock <= $producto->stock_minimo * 2)
                                    <span class="badge bg-warning text-dark">{{ $producto->stock }}</span>
                                @else
                                    <span class="badge bg-success">{{ $producto->stock }}</span>
                                @endif
                            </td>
                            <td>{{ $producto->stock_minimo }}</td>
                            <td>${{ number_format($producto->precio_unitario, 2) }}</td>

                            {{-- ✅ Toggle de estado corregido --}}
                            <td class="text-center">
                                <div class="custom-control custom-switch">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input status-toggle"
                                        id="status-{{ $producto->id }}"
                                        data-url="{{ route('productos.toggle-status', $producto) }}"
                                        {{ $producto->status ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="status-{{ $producto->id }}">
                                        <span class="badge {{ $producto->status ? 'badge-success' : 'badge-danger' }}">
                                            {{ $producto->status ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </label>
                                </div>
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
                            <td colspan="8" class="text-center text-muted">No hay productos registrados.</td>
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
                    body:     'No se pudo cambiar el estado.',
                    autohide:  true,
                    delay:     3000,
                    class:    'bg-danger',
                });
            }
        });
    });
</script>
@endpush