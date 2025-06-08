<?php

namespace App\Http\Controllers;
use App\Models\Real;
use Illuminate\Http\Request;

class EstadisticasController extends Controller
{
    private $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

    public function importeMensual(string $mes, string $anno){
       $importe = 0;
       $productos= Real::where('anno', $anno)
       ->whereRaw('mes', $mes)->get();
       foreach ($productos as $producto){
         $importe += $producto->cantidad * $producto->precio;
       }
       return $importe;
    }

    public function show(){
        return view('estadisticas.estadisticas');
    }

   // public function importeAnual(string $anno){
     // $importe = 0;
      //foreach($this->$meses as $mes){
       // $importe += $this->importeMensual($mes, $anno);
      //}
      //return $importe;
    // }

    public function realMensual(string $mes, string $anno){
        $importe = 0;
        $productos= Real::where('anno', $anno)
        ->whereRaw('mes', $mes)->get();
        foreach ($productos as $producto){
          $importe += $producto->cantidad * $producto->precio;
        }

    }

    public function realPorcentualMensual(string $anno){

    }
}
