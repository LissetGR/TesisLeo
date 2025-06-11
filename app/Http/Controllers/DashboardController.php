<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::now();
        $mesActual = $hoy->month;
        $annoActual = $hoy->year;
        $mesAnterior = $hoy->copy()->subMonth()->month;
        $annoAnterior = $hoy->copy()->subMonth()->year;
    
        // 1. Crecimiento: total cantidad Real mes vs mes anterior
        $totalRealActual = Real::where('mes', $mesActual)->where('anno', $annoActual)->sum('cantidad');
        $totalRealAnterior = Real::where('mes', $mesAnterior)->where('anno', $annoAnterior)->sum('cantidad');
        $crecimiento = $totalRealAnterior > 0
            ? round((($totalRealActual - $totalRealAnterior) / $totalRealAnterior) * 100, 2)
            : null;
    
        // 2. Actividad diaria: conteo de registros Real últimos 7 días
        $actividad_diaria = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = $hoy->copy()->subDays($i);
            $count = Real::whereDate('created_at', $fecha)->count();
            $actividad_diaria[$fecha->format('D')] = $count;
        }
        if ($actividad_diaria) {
            $max = max($actividad_diaria);
            foreach ($actividad_diaria as $d => $c) {
                $actividad_diaria[$d] = $max ? round(($c / $max) * 100) : 0;
            }
        }
    
        // 3. Eficiencia: promedio de (cantidad real / cantidad plan) % para mes actual
        $cumplimientos = Producto::with([
            'plans' => fn($q) => $q->where('mes', $mesActual)->where('anno', $annoActual),
            'reals' => fn($q) => $q->where('mes', $mesActual)->where('anno', $annoActual)
        ])->get()->map(function($p){
            $plan = $p->plans->first();
            $real = $p->reals->first();
            if ($plan && $plan->cantidad > 0 && $real) {
                return ($real->cantidad / $plan->cantidad) * 100;
            }
            return null;
        })->filter()->all();
    
        $eficiencia = count($cumplimientos) > 0
            ? round(array_sum($cumplimientos) / count($cumplimientos), 2)
            : null;
    
        return view('dashboard', compact('crecimiento', 'actividad_diaria', 'eficiencia'));
    }
}
