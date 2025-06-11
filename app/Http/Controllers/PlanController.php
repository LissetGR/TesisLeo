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

    public function create()
    {
        $anno= Carbon::now()->year;
        $productos= Producto::all();
        return view ('plan.create',['productos'=> $productos,
        'anno'=>$anno]);
    }

    public function show($id){
      $plan = Plan::find($id);
    }

    public function store(Request $request)
    {
        if ($request->has('productos')) {
            $productos = json_decode($request->productos, true);

            if (is_array($productos)) {
                foreach ($productos as $producto) {
                    // Verificar si ya existe un plan para el mismo mes, año y producto
                    $existingPlan = Plan::where('mes', $producto['mes'])
                                        ->where('anno', $producto['anno'])
                                        ->where('productos_id', $producto['productos_id'])
                                        ->first();

                    if ($existingPlan) {
                        // Si ya existe, actualiza los valores en lugar de crear un nuevo plan
                        $existingPlan->update([
                            'cantidad' => $producto['cantidad'],
                            'precio' => $producto['precio']
                        ]);
                    } else {
                        // Si no existe, crear un nuevo plan
                        Plan::create([
                            'mes' => $producto['mes'],
                            'anno' => $producto['anno'],
                            'productos_id' => $producto['productos_id'],
                            'cantidad' => $producto['cantidad'],
                            'precio' => $producto['precio']
                        ]);
                    }
                }

                return redirect()->route('plan.index')->with('success', 'Plan creado o actualizado con éxito.');
            } else {
                return back()->withErrors(['productos' => 'Los productos no se enviaron correctamente.']);
            }
        } else {
            return back()->withErrors(['productos' => 'No se recibieron productos.']);
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
