<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Producto;
use App\Http\Resources\PlanResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePlan;
use App\Http\Requests\UpdatePlan;

class PlanController extends Controller
{

    public function create(Request $request)
    {
        $producto_id = $request->input('producto_id');
        $mes = $request->input('mes');
        $anno = $request->input('year', now()->year);

        $producto = Producto::findOrFail($producto_id);
        $productos = Producto::all();


        return view('plan.create', [
            'producto' => $producto,
            'productos' => $productos,
            'producto_id' => $producto_id,
            'mes' => $mes,
            'anno' => $anno,
        ]);
    }

    public function show($id){
      $plan = Plan::find($id);
    }

    public function store(Request $request)
    {
        if ($request->has('productos')) {
            // Manejo de múltiples productos
            $productos = json_decode($request->productos, true);
    
            if (is_array($productos)) {
                foreach ($productos as $producto) {
                    $existingPlan = Plan::where('mes', $producto['mes'])
                        ->where('anno', $producto['anno'])
                        ->where('productos_id', $producto['productos_id'])
                        ->first();
    
                    if ($existingPlan) {
                        $existingPlan->update([
                            'cantidad' => $producto['cantidad'],
                            'precio' => $producto['precio']
                        ]);
                    } else {
                        Plan::create([
                            'mes' => $producto['mes'],
                            'anno' => $producto['anno'],
                            'productos_id' => $producto['productos_id'],
                            'cantidad' => $producto['cantidad'],
                            'precio' => $producto['precio']
                        ]);
                    }
                }
    
                return redirect()->route('plan.index')->with('success', 'Planes creados o actualizados con éxito.');
            } else {
                return back()->withErrors(['productos' => 'Los productos no se enviaron correctamente.']);
            }
        } else {
            // Manejo de un solo producto
            $request->validate([
                'producto_id' => 'required|exists:productos,id',
                'mes' => 'required|string',
                'year' => 'required|integer',
                'cantidad' => 'required|numeric',
                'precio' => 'required|numeric',
            ]);
    
            $existingPlan = Plan::where('mes', $request->mes)
                ->where('anno', $request->year)
                ->where('productos_id', $request->producto_id)
                ->first();
    
            if ($existingPlan) {
                $existingPlan->update([
                    'cantidad' => $request->cantidad,
                    'precio' => $request->precio
                ]);
            } else {
                Plan::create([
                    'mes' => $request->mes,
                    'anno' => $request->year,
                    'productos_id' => $request->producto_id,
                    'cantidad' => $request->cantidad,
                    'precio' => $request->precio
                ]);
            }
    
            return redirect()->route('plan.index')->with('success', 'Plan creado o actualizado con éxito.');
        }
    }


    public function edit(Plan $plan){
        $anno= Carbon::now()->year;
        $productos= Producto::all();
        return view('plan.edit', [
            'plan' => $plan,
            'productos' => $productos,
            'anno' => $anno
        ]);
    }
        public function getTotalesPorMes($anno = null)
{
    $anno = $anno ?? Carbon::now()->year; // Usa el año actual si no se especifica

    $totales = Plan::select(
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

    $total = Plan::where('anno', $anno)
        ->select(
            DB::raw('SUM(cantidad) as total_cantidad'),
            DB::raw('SUM(cantidad * precio) as total_precio')
        )
        ->first();

    return $total;
}
    public function update(Request $request, Plan $plan)
    {
        // Validar los datos del formulario
        $request->validate([
            'cantidad' => 'required|numeric',
            'precio' => 'required|numeric',
        ]);

        // Depuración: Verifica si los datos llegan bien
        // dd($request->all());

        // Asegurar que el plan existe antes de actualizarlo
        if (!$plan) {
            return back()->withErrors(['error' => 'El plan no existe.']);
        }

        // Actualizar el plan con los nuevos valores
        $plan->update([
            'cantidad' => $request->cantidad,
            'precio' => $request->precio,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('plan.index')->with('success', 'Plan actualizado correctamente.');
    }



    public function destroy(Plan $plan){
      $plan->delete();
      return redirect()->route('plan.index');
    }
    
    public function index(Request $request)
    {
        // Obtener el año de la query string o usar el año actual por defecto
        $year = $request->input('year', Carbon::now()->year);
    
        $plan = Producto::with(['plans' => function($query) use ($year) {
            $query->where('anno', $year);
        }])->get();
    
        $totalesPorMes = $this->getTotalesPorMes($year);
        $totalesAnuales = $this->getTotalesAnuales($year);
    
        return view('plan.index', [
            'plan' => $plan,
            'totalesPorMes' => $totalesPorMes,
            'totalesAnuales' => $totalesAnuales,
            'year' => $year,  // Pasamos el año para el select en la vista
        ]);
    }
    
}
