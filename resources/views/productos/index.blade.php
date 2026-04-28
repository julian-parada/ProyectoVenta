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
                                @if($producto->stock <= $producto->stock_minimo)
                                    <span class="badge bg-danger">{{ $producto->stock }}</span>
                                @else
                                    <span class="badge bg-success">{{ $producto->stock }}</span>
                                @endif
                            </td>
                            <td>{{ $producto->stock_minimo }}</td>
                            <td>${{ number_format($producto->precio_unitario, 2) }}</td>
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
                            // //
                            <td>
                                @if($producto->stock <= $producto->stock_minimo)
                                    <span class="badge bg-danger">{{ $producto->stock }}</span>
                                    <i class="bi bi-exclamation-triangle-fill text-warning" title="Stock bajo el mínimo"></i>
                                @elseif($producto->stock <= $producto->stock_minimo * 2)
                                    <span class="badge bg-warning text-dark">{{ $producto->stock }}</span>
                                @else
                                    <span class="badge bg-success">{{ $producto->stock }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection