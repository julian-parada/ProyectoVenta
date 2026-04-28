<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'          => 'required|string|max:255',
            'codigo'          => 'required|string|unique:productos',
            'stock'           => 'required|integer|min:0',
            'stock_minimo'    => 'required|integer|min:0',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        Producto::create($request->all());
        return redirect()->route('productos.index')
                         ->with('success', 'Producto creado correctamente.');
    }

    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre'          => 'required|string|max:255',
            'codigo'          => 'required|string|unique:productos,codigo,' . $producto->id,
            'stock'           => 'required|integer|min:0',
            'stock_minimo'    => 'required|integer|min:0',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        $producto->update($request->all());
        return redirect()->route('productos.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')
                         ->with('success', 'Producto eliminado correctamente.');
    }
}