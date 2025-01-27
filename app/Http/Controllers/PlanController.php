<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlan;
use App\Models\Plan;
use App\Models\Producto;
use App\Http\Resources\PlanResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PlanController extends Controller
{

    public function create(){
        $anno= Carbon::now()->year;
        $productos= Producto::all();
        return view ('plan.create',['productos'=> $productos,
        'anno'=>$anno
    ]);
    }

    public function show($id){
      $plan = Plan::find($id);
    }

    public function store(StorePlan $request){
       $plan= Plan::create($request->all());
       return redirect()->route('plan.index', $plan);
    }

    public function edit(Plan $plan){
        $anno= Carbon::now()->year;
        $productos= Producto::all();
        return view('plan.create', [
            'plan' => $plan,
            'productos' => $productos,
            'anno' => $anno 
        ]);
    }

    public function update( $id, Request $request){

        $plan=Plan::findOrFail($id);
       $plan->update($request->all());
       return redirect()->route('plan.index', ['plan'=>$plan]);
    }

    public function destroy(Plan $plan){
      $plan->delete();
      return redirect()->route('plan.index');
    }
    public function index(){
        $current_year = Carbon::now()->year;
        $plan = Producto::with(['plans' => function($query) use ($current_year) {
            $query->where('anno', $current_year);
        }])->get();

        return view ('plan.index', ['plan'=> $plan]);

    }
}
