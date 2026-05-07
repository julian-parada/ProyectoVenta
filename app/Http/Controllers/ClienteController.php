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
        $cliente->delete();
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }

    // app/Http/Controllers/ClientController.php
    public function toggleStatus(Cliente $cliente)
    {
        $cliente->update(['status' => !$cliente->status]);

        return response()->json([
            'status' => $cliente->status,
            'message' => $cliente->status ? 'Cliente activado' : 'Cliente desactivado',
        ]);
    }
}