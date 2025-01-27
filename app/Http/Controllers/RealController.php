<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReal;
use App\Http\Resources\RealResource;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Real;
use App\Models\Producto;
use Illuminate\Support\Carbon;
class RealController extends Controller
{
    public function create(){
        $anno= Carbon::now()->year;
        $productos= Producto::all();
        return view ('real.create',['productos'=> $productos,
        'anno'=>$anno
    ]);
    }

    public function show($id){
      $real = Real::find($id);
    }

    public function store(StoreReal $request){
       $plan_id= Plan::where('mes', $request->input('mes'))
       ->where('anno',  $request->input('anno'))

       ->where('productos_id', $request->input('productos_id'))->first();
       $real= Real::create([
        'cantidad'=>$request->input('cantidad'),
        'precio'=>$request->input('precio'),
         'plans_id'=>$plan_id->id
       ]);

       return redirect()->route('real.index', $real);
    }

    public function edit(Real $real){
        return view ('real.create',$real);
    }

    public function update(StoreReal $real, Request $request){
       $real->update($request->all());
       return redirect()->route('real.index', ['real'=>$real]);
    }

    public function destroy(Real $real){
      $real->delete();
      return redirect()->route('real.index');
    }
    public function index(){
        $current_year = Carbon::now()->year;

        $real = Producto::with(['plans' => function($query) use ($current_year) {
            $query->where('anno', $current_year);
        }])
        ->with('plans.reals')
        ->get();

        // return response()->json($real);

        return view ('real.index', ['real'=>$real]);
    }
}
