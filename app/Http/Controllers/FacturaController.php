<?php
namespace App\Http\Controllers;
use App\Models\Pago;
use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Producto;
use App\Models\Detalle;
use App\Models\MetodoPago;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FacturaExport;
use App\Exports\FacturasExport;

class FacturaController extends Controller
{
    public function imprimirPdf($id)
    {
        $factura = Factura::with(['cliente', 'empleado', 'detalles.producto'])->findOrFail($id);
        $pdf = Pdf::loadView('facturas.pdf', compact('factura'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('factura-' . $id . '.pdf');
    }
    public function exportarPdf()
{
    $facturas = Factura::with(['cliente', 'empleado', 'detalles.producto'])->get();
    $pdf = Pdf::loadView('facturas.pdf', compact('facturas'))
              ->setPaper('a4', 'portrait');
    return $pdf->stream('facturas.pdf');
}

    public function exportarExcel($id)
    {
        $factura = Factura::with(['cliente', 'empleado', 'detalles.producto'])->findOrFail($id);
        return Excel::download(new FacturaExport($factura), 'factura-' . $id . '.xlsx');
    }

    public function exportarExcelGeneral()
    {
        return Excel::download(new FacturasExport, 'facturas-general.xlsx');
    }
    public function index()
    {
        $facturas = Factura::with("cliente", "empleado")->get();
        return view("facturas.index", compact("facturas"));
    }


    public function create()
    {
        $clientes = Cliente::all();
        $empleados = Empleado::all();
        $productos = Producto::all();
        $metodos = MetodoPago::all();

        return view('facturas.create', compact('clientes', 'empleados', 'productos', 'metodos'));
    }



    public function store(Request $request)
    {
        // Filtrar productos vacíos antes de validar
        $productosLimpios = collect($request->productos)
            ->filter(fn($item) => !empty($item['id']))
            ->values()
            ->toArray();

        $request->merge(['productos' => $productosLimpios]);

        $request->validate([
            "cliente_id" => "required|exists:clientes,id",
           
            "fecha" => "required|date",
            "tipo_pago" => "required|string",
            "productos" => "required|array|min:1",
            "productos.*.id" => "required|exists:productos,id",
            "productos.*.cantidad" => "required|integer|min:1",
            "abono_inicial" => "nullable|numeric|min:0",
            "efectivo_recibido" => "nullable|numeric|min:0",
            'metodopago_id' => 'required',
        ]);

        // Verificar stock
        foreach ($request->productos as $item) {
            $producto = Producto::find($item["id"]);
            if ($producto->stock < $item["cantidad"]) {
                return back()->withInput()->with(
                    "error",
                    "Stock insuficiente para {$producto->nombre}. Disponible: {$producto->stock} unidades."
                );
            }
        }

        // Calcular total
        $total = 0;
        foreach ($request->productos as $item) {
            $producto = Producto::find($item["id"]);
            $total += $producto->precio_unitario * $item["cantidad"];
        }

        // Calcular saldo y vuelto
        $vuelto = 0;
        $saldo = 0;

        if ($request->tipo_pago === 'contado') {
            $efectivo = floatval($request->efectivo_recibido ?? 0);

            // Verificar que el efectivo sea suficiente
            if ($efectivo < $total) {
                $faltante = $total - $efectivo;
                return back()->withInput()->with(
                    'error',
                    " Efectivo insuficiente. Total: $" . number_format($total, 2) .
                    " | Recibido: $" . number_format($efectivo, 2) .
                    " | Falta: $" . number_format($faltante, 2)
                );
            }

            $vuelto = $efectivo - $total;
            $saldo = 0;
            $estado = 'pagada';

        } else {
            // Crédito
            $abono = floatval($request->abono_inicial ?? 0);
            $vuelto = 0;
            $saldo = max(0, $total - $abono);
            $estado = $saldo > 0 ? 'pendiente' : 'pagada';
        }

        // Crear factura
       

        $factura = Factura::create([
            "cliente_id" => $request->cliente_id,
            "empleado_id" => $request->empleado_id, 
            "fecha" => $request->fecha,
            "tipo_pago" => $request->tipo_pago,
            "total" => $total,
            "saldo_pendiente" => $saldo,
            "estado" => $estado,
            'efectivo_recibido' => $request->efectivo_recibido,
            'vuelto' => $vuelto > 0 ? $vuelto : 0,
        ]);
        // Crear detalles y descontar stock
        $alertas = [];
        foreach ($request->productos as $item) {
            $producto = Producto::find($item["id"]);
            Detalle::create([
                "factura_id" => $factura->id,
                "producto_id" => $producto->id,
                "cantidad" => $item["cantidad"],
                "subtotal" => $producto->precio_unitario * $item["cantidad"],
            ]);
            $producto->decrement("stock", $item["cantidad"]);
            $producto->refresh();
            if ($producto->stock <= $producto->stock_minimo) {
                $alertas[] = "{$producto->nombre} está por agotarse. Stock actual: {$producto->stock} (mínimo: {$producto->stock_minimo}).";
            }
        }

        // Registrar pago inicial
        if ($request->tipo_pago === 'contado' || ($request->tipo_pago === 'credito' && ($request->abono_inicial ?? 0) > 0)) {
            $montoAbono = $request->tipo_pago === 'contado' ? $total : min($request->abono_inicial, $total);
            Pago::create([
                'factura_id' => $factura->id,
                'monto' => $montoAbono,
                'fecha_pago' => now()->format('Y-m-d'),
                'metodopago_id' => $request->metodopago_id,
            ]);
        }

        $mensaje = " Factura #{$factura->id} creada correctamente.";

        if ($request->tipo_pago === 'contado') {
            $mensaje .= " | Total: $" . number_format($total, 2);
            $mensaje .= " | Efectivo: $" . number_format($request->efectivo_recibido ?? $total, 2);
            if ($vuelto > 0) {
                $mensaje .= " |  Vuelto: $" . number_format($vuelto, 2);
            }
        } else {
            if ($saldo > 0) {
                $mensaje .= " | Saldo pendiente: $" . number_format($saldo, 2);
            } else {
                $mensaje .= " |  Pagada completamente.";
            }
        }

        $redirect = redirect()->route('facturas.show', $factura->id)->with('success', $mensaje);
        if (!empty($alertas)) {
            $redirect = $redirect->with('alertas_stock', $alertas);
        }
        return $redirect;
    }




    public function abonar(Request $request, Factura $factura)
    {
        $request->validate([
            'monto' => 'required|numeric|min:1',
        ]);

        $monto = $request->monto;
        $vuelto = 0;

        // Calcular vuelto si paga de más
        if ($monto > $factura->saldo_pendiente) {
            $vuelto = $monto - $factura->saldo_pendiente;
            $monto = $factura->saldo_pendiente;
        }

        // Registrar pago
        Pago::create([
            'factura_id' => $factura->id,
            'monto' => $monto,
            'fecha_pago' => now()->format('Y-m-d'),
            'metodopago_id' => $request->metodopago_id,
        ]);

        // Actualizar saldo
        $nuevoSaldo = $factura->saldo_pendiente - $monto;
        $factura->update([
            'saldo_pendiente' => $nuevoSaldo,
            'estado' => $nuevoSaldo <= 0 ? 'pagada' : 'pendiente',
        ]);

        $mensaje = $nuevoSaldo <= 0
            ? ' Factura pagada completamente.'
            : ' Abono registrado. Saldo pendiente: $' . number_format($nuevoSaldo, 2);

        if ($vuelto > 0) {
            $mensaje .= "  Vuelto: $" . number_format($vuelto, 2);
        }

        return redirect()->route('facturas.show', $factura->id)->with('success', $mensaje);
    }
    public function show(Factura $factura)
    {
        $factura->load('cliente', 'empleado', 'detalles.producto', 'pagos');
        return view('facturas.show', compact('factura'));
    }

    public function edit(Factura $factura)
    {
        $factura->load("detalles.producto");
        return view("facturas.edit", compact("factura"));
    }

    public function update(Request $request, Factura $factura)
    {
        $request->validate([
            "tipo_pago" => "required|string",
            "estado" => "required|string",
        ]);

        $factura->update([
            "tipo_pago" => $request->tipo_pago,
            "estado" => $request->estado,
            "saldo_pendiente" => $request->tipo_pago === "credito" ? $factura->total : 0,
        ]);

        return redirect()->route("facturas.index")->with("success", "Factura actualizada correctamente.");
    }

    public function destroy(Factura $factura)
    {
        try {
            $factura->detalles()->delete();
            $factura->delete();
            return redirect()->route('facturas.index')->with('successMsg', 'El registro se eliminó exitosamente');
        } catch (QueryException $e) {
            // Capturar y manejar violaciones de restricción de clave foránea
            Log::error('Error al eliminar el país: ' . $e->getMessage());
            return redirect()->route('facturas.index')->withErrors('El registro que desea eliminar tiene información relacionada. Comuníquese con el Administrador');
        } catch (Exception $e) {
            // Capturar y manejar cualquier otra excepción
            Log::error('Error inesperado al eliminar el país: ' . $e->getMessage());
            return redirect()->route('facturas.index')->withErrors('Ocurrió un error inesperado al eliminar el registro. Comuníquese con el Administrador');
        }
    }

    public function cambioestadofactura(Request $request)
    {
        $factura = Factura::find($request->id);
        $factura->estado = $request->estado;
        $factura->save();
    }

}
