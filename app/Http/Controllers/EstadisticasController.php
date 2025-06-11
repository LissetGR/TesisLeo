<?php

namespace App\Http\Controllers;

use App\Models\Real;
use App\Models\Plan;
use App\Models\Producto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EstadisticasExport;

class EstadisticasController extends Controller
{
    private $meses = [
        'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
        'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
    ];

    public function show(Request $request)
    {
        $anno = $request->get('anno', date('Y'));

        // Datos estadísticos por mes
        $estadisticas = collect($this->meses)->map(function($mes) use ($anno) {
            $importeReal = $this->calcularImporteReal($mes, $anno);
            $importePlan = $this->calcularImportePlan($mes, $anno);
            $importe = $this->calcularImporte($mes, $anno);
            $cumplimiento = $importePlan > 0 ? round(($importeReal / $importePlan) * 100, 2) : 0;
            $topProductos = $this->topProductos($mes, $anno, 3);

            return [
                'mes' => ucfirst($mes),
                'importe_real' => $importeReal,
                'importe_plan' => $importePlan,
                'importe' => $importe,
                'cumplimiento' => $cumplimiento,
                'top_productos' => $topProductos,
            ];
        });

        return view('estadisticas.estadisticas', compact('estadisticas', 'anno'));
    }

    private function calcularImporteReal(string $mes, int $anno): float
    {
        return Real::where('anno', $anno)
            ->where('mes', $mes)
            ->sum(\DB::raw('cantidad'));
    }
    private function calcularImporte(string $mes, int $anno): float
    {
        return Real::where('anno', $anno)
            ->where('mes', $mes)
            ->sum(\DB::raw('cantidad * precio'));
    }


    private function calcularImportePlan(string $mes, int $anno): float
    {
        return Plan::where('anno', $anno)
            ->where('mes', $mes)
            ->sum(\DB::raw('cantidad'));
    }

    private function topProductos(string $mes, int $anno, int $limit = 5)
    {
        $productosReal = Real::with('productos')
        ->select('productos_id')
        ->selectRaw('SUM(cantidad * precio) as total_importe_real')
        ->where('mes', $mes)
        ->where('anno', $anno)
        ->groupBy('productos_id')
        ->orderByDesc('total_importe_real')
        ->limit($limit)
        ->get();

    // Obtener importe plan por producto
    $productosPlan = Plan::select('productos_id')
        ->selectRaw('SUM(cantidad * precio) as total_importe_plan')
        ->where('mes', $mes)
        ->where('anno', $anno)
        ->groupBy('productos_id')
        ->get()
        ->keyBy('productos_id');

    // Mapear productos y combinar datos plan y real
    return $productosReal->map(function($item) use ($productosPlan) {
        $plan = $productosPlan->has($item->productos_id) ? $productosPlan[$item->productos_id]->total_importe_plan : 0;
        $real = $item->total_importe_real;
        $cumplimiento = $plan > 0 ? round(($real / $plan) * 100, 2) : 0;

        return [
            'nombre' => $item->productos ? $item->productos->nombre : 'Producto desconocido',
            'plan' => $plan,
            'real' => $real,
            'cumplimiento' => $cumplimiento,
        ];
    });
    }

    public function export(Request $request)
  {
    $anno = $request->get('anno', date('Y'));

    $estadisticas = collect($this->meses)->flatMap(function ($mes) use ($anno) {
        $importeReal = $this->calcularImporteReal($mes, $anno);
        $importePlan = $this->calcularImportePlan($mes, $anno);
        $cumplimiento = $importePlan > 0 ? round(($importeReal / $importePlan) * 100, 2) : 0;
        $topProductos = $this->topProductos($mes, $anno, 3);

        $resumen = [[
            'mes' => strtoupper($mes),
            'producto' => 'TOTAL GENERAL',
            'plan' => $importePlan,
            'real' => $importeReal,
            'cumplimiento' => $cumplimiento,
            'tipo' => 'resumen',
        ]];

        $detalles = collect($topProductos)->map(function ($producto) use ($mes) {
            return [
                'mes' => '',
                'producto' => '   - ' . ($producto['nombre'] ?? 'Sin nombre'),
                'plan' => $producto['plan'] ?? 0,
                'real' => $producto['real'] ?? 0,
                'cumplimiento' => $producto['cumplimiento'] ?? 0,
                'tipo' => 'detalle',
            ];
        })->toArray();

        return array_merge($resumen, $detalles);
    });

    return Excel::download(new EstadisticasExport($estadisticas), "estadisticas_{$anno}.xlsx");
  }

}
