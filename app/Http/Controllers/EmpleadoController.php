<?php
namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'cargo'        => 'required|string|max:100',
            'telefono'     => 'nullable|string|max:20',
            'departamento' => 'nullable|string|max:100',
            'salario'      => 'nullable|numeric|min:0',
            'estado'       => 'required|string',
        ]);

        Empleado::create($request->all());
        return redirect()->route('empleados.index')
                         ->with('success', 'Empleado creado correctamente.');
    }

    public function show(Empleado $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'cargo'        => 'required|string|max:100',
            'telefono'     => 'nullable|string|max:20',
            'departamento' => 'nullable|string|max:100',
            'salario'      => 'nullable|numeric|min:0',
            'estado'       => 'required|string',
        ]);

        $empleado->update($request->all());
        return redirect()->route('empleados.index')
                         ->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->delete();
        return redirect()->route('empleados.index')
                         ->with('success', 'Empleado eliminado correctamente.');
    }
}