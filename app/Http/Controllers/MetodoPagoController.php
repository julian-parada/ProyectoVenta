<?php
namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Http\Request;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $metodopagos = MetodoPago::all();
        return view('metodopagos.index', compact('metodopagos'));
    }

    public function create()
    {
        return view('metodopagos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'estado'      => 'required|string',
        ]);

        MetodoPago::create($request->all());
        return redirect()->route('metodopagos.index')
                         ->with('success', 'Método de pago creado correctamente.');
    }

    public function show(MetodoPago $metodopago)
    {
        return view('metodopagos.show', compact('metodopago'));
    }

    public function edit(MetodoPago $metodopago)
    {
        return view('metodopagos.edit', compact('metodopago'));
    }

    public function update(Request $request, MetodoPago $metodopago)
    {
        $request->validate([
            'nombre'      => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'estado'      => 'required|string',
        ]);

        $metodopago->update($request->all());
        return redirect()->route('metodopagos.index')
                         ->with('success', 'Método de pago actualizado correctamente.');
    }

    public function destroy(MetodoPago $metodopago)
    {
        $metodopago->delete();
        return redirect()->route('metodopagos.index')
                         ->with('success', 'Método de pago eliminado correctamente.');
    }
}