<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
 use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClienteExport;

class ClienteController extends Controller
{
   


public function exportarPdfGeneral()
{
    $clientes = Cliente::all();
    $pdf = Pdf::loadView('clientes.pdf', compact('clientes'))
              ->setPaper('a4', 'portrait');
    return $pdf->stream('clientes.pdf');
}

public function exportarExcelGeneral()
{
    return Excel::download(new ClienteExport, 'clientes-general.xlsx');
}
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:clientes',
            'n_identificacion' => 'required|string|unique:clientes',
            'direccion' => 'nullable|string',
        ]);

        Cliente::create($request->all());
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'n_identificacion' => 'required|string|unique:clientes,n_identificacion,' . $cliente->id,
            'direccion' => 'nullable|string',
        ]);

        $cliente->update($request->all());
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

     public function destroy(Cliente $cliente)
    {
		try {
            $cliente->facturas()->delete();
            
            $cliente->delete();
            return redirect()->route('clientes.index')->with('successMsg', 'El registro se eliminó exitosamente');
        } catch (QueryException $e) {
            // Capturar y manejar violaciones de restricción de clave foránea
            Log::error('Error al eliminar el cliente: ' . $e->getMessage());
            return redirect()->route('clientes.index')->withErrors('El registro que desea eliminar tiene información relacionada. Comuníquese con el Administrador');
        } catch (Exception $e) {
            // Capturar y manejar cualquier otra excepción
            Log::error('Error inesperado al eliminar el cliente: ' . $e->getMessage());
            return redirect()->route('clientes.index')->withErrors('Ocurrió un error inesperado al eliminar el registro. Comuníquese con el Administrador');
        }
    }

    // app/Http/Controllers/ClientController.php
    public function toggleStatus(Cliente $cliente)
    {
        $newStatus = !$cliente->status;
        $cliente->update(['status' => $newStatus]);

        return response()->json([
            'status' => $newStatus,
            'message' => $newStatus ? 'Cliente activado' : 'Cliente desactivado',
        ]);
    }
}