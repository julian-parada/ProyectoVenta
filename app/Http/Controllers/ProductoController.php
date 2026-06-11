<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductoExport;


class ProductoController extends Controller
{


public function exportarPdf()
{
    $productos = Producto::all();
    $pdf = Pdf::loadView('productos.pdf', compact('productos'))
              ->setPaper('a4', 'portrait');
    return $pdf->stream('productos.pdf');
}

public function exportarExcel()
{
    return Excel::download(new ProductoExport, 'productos.xlsx');
}

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
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:productos',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
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
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:productos,codigo,' . $producto->id,
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'precio_unitario' => 'required|numeric|min:0',
        ]);

        $producto->update($request->all());
        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

     public function destroy(Producto $producto)
    {
		try {
            $producto->detalles()->delete();
            $producto->delete();
            return redirect()->route('productos.index')->with('successMsg', 'El registro se eliminó exitosamente');
        } catch (QueryException $e) {
            // Capturar y manejar violaciones de restricción de clave foránea
            Log::error('Error al eliminar el producto: ' . $e->getMessage());
            return redirect()->route('productos.index')->withErrors('El registro que desea eliminar tiene información relacionada. Comuníquese con el Administrador');
        } catch (Exception $e) {
            // Capturar y manejar cualquier otra excepción
            Log::error('Error inesperado al eliminar el producto: ' . $e->getMessage());
            return redirect()->route('productos.index')->withErrors('Ocurrió un error inesperado al eliminar el registro. Comuníquese con el Administrador');
        }
    }
     public function toggleStatus(Producto $producto)
    {
        $newStatus = !$producto->status;
        $producto->update(['status' => $newStatus]);

        return response()->json([
            'status' => $newStatus,
            'message' => $newStatus ? 'producto activado' : 'producto desactivado',
        ]);
    }
}