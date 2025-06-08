<?php

namespace App\Http\Controllers;

use App\Models\Real;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreReal;
use App\Http\Requests\UpdateReal;
use SessionUpdateTimestampHandlerInterface;

class RealController extends Controller
{
    public function create()
    {
        $anno= Carbon::now()->year;
        $productos= Producto::all();
        return view ('real.create',['productos'=> $productos,
        'anno'=>$anno]);
        ;
    }
    public function show($id){
        $real = Real::find($id);
    }

    public function store(Request $request)
    {
        if ($request->has('productos')) {
            $productos = json_decode($request->productos, true);

            if (is_array($productos)) {
                foreach ($productos as $producto) {
                    // Verificar si ya existe un real para el mismo mes, año y producto
                    $existingReal = Real::where('mes', $producto['mes'])
                                        ->where('anno', $producto['anno'])
                                        ->where('producto_id', $producto['productos_id'])
                                        ->first();

                    if ($existingReal) {
                        // Si ya existe, actualiza los valores en lugar de crear un nuevo real
                        $existingReal->update([
                            'cantidad' => $producto['cantidad'],
                            'precio' => $producto['precio']
                        ]);
                    } else {
                        // Si no existe, crear un nuevo plan
                        Real::create([
                            'mes' => $producto['mes'],
                            'anno' => $producto['anno'],
                            'producto_id' => $producto['productos_id'],
                            'cantidad' => $producto['cantidad'],
                            'precio' => $producto['precio']
                        ]);
                    }
                }

                return redirect()->route('real.index')->with('success', 'Real creado o actualizado con éxito.');
            } else {
                return back()->withErrors(['producto' => 'Los productos no se enviaron correctamente.']);
            }
        } else {
            return back()->withErrors(['productos' => 'No se recibieron productos.']);
        }
    }
    public function update(Request $request, Real $real)
    {
        // Validar los datos del formulario
        $request->validate([
            'cantidad' => 'required|numeric',
            'precio' => 'required|numeric',
        ]);

        // Depuración: Verifica si los datos llegan bien
        // dd($request->all());

        // Asegurar que el plan existe antes de actualizarlo
        if (!$real) {
            return back()->withErrors(['error' => 'El real no existe.']);
        }

        // Actualizar el real con los nuevos valores
        $real->update([
            'cantidad' => $request->cantidad,
            'precio' => $request->precio,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('real.index')->with('success', 'Real actualizado correctamente.');
    }

    public function edit(Real $real){
        $anno= Carbon::now()->year;
        $producto= Producto::all();
        return view('real.edit', [
            'real' => $real,
            'producto' => $producto,
            'anno' => $anno
        ]);
    }
    public function getTotalesPorMes($anno = null)
{
    $anno = $anno ?? Carbon::now()->year; // Usa el año actual si no se especifica

    $totales = Real::select(
            'mes',
            DB::raw('SUM(cantidad) as total_cantidad'),
            DB::raw('SUM(cantidad * precio) as total_precio') // Suma de (cantidad * precio)
        )
        ->where('anno', $anno)
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

    return $totales;
}
    public function getTotalesAnuales($anno = null)
{
    $anno = $anno ?? Carbon::now()->year;

    $total = Real::where('anno', $anno)
        ->select(
            DB::raw('SUM(cantidad) as total_cantidad'),
            DB::raw('SUM(cantidad * precio) as total_precio')
        )
        ->first();

    return $total;
}
    public function index()
    {
        $currentYear = Carbon::now()->year;
        $real = Producto::with(['reals' => function($query) use ($currentYear) {
            $query->where('anno', $currentYear);
                  }])->get();
            $totalesPorMes = $this->getTotalesPorMes($currentYear);
            $totalesAnuales = $this->getTotalesAnuales($currentYear);
     
        return view('real.index', [
            'real' => $real,
            'totalesPorMes' => $totalesPorMes,
            'totalesAnuales' => $totalesAnuales
        ]);
    }



    public function destroy(Real $real)
    {
            $real->delete();
            return redirect()->route('real.index')
                ->with('success', 'Registro eliminado correctamente');
    }
}
