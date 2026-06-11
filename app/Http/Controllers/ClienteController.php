<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
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
        $cliente->update($request->validated());
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

   public function destroy(Cliente $cliente)
{
    try {
        // 1. Eliminar detalles de cada factura
        foreach ($cliente->facturas as $factura) {
            $factura->detalles()->delete();
            $factura->pagos()->delete(); // si tienes pagos también
        }
        // 2. Eliminar facturas
        $cliente->facturas()->delete();
        // 3. Eliminar cliente
        $cliente->delete();

        return redirect()->route('clientes.index')->with('successMsg', 'El registro se eliminó exitosamente');
    } catch (QueryException $e) {
        Log::error('Error al eliminar el cliente: ' . $e->getMessage());
        return redirect()->route('clientes.index')->withErrors('El registro que desea eliminar tiene información relacionada. Comuníquese con el Administrador');
    } catch (Exception $e) {
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