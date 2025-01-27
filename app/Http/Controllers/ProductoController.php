<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function create(){
        return view ('productos.create');
    }

    public function show($id){
      $producto = Producto::find($id);
    }

    public function store(StoreProduct $request){

       if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('images', 'public');
        $producto= Producto::create([
            'nombre'=> $request->input('nombre'),
            'u_medida'=> $request->input('u_medida'),
            'photo'=> $path
        ]);
        }else{
            $producto= Producto::create($request->all());
        }
       return redirect()->route('productos.index', $producto);
    }

    public function edit(Producto $producto){
        return view ('productos.create',['producto' => $producto]);
    }

    public function update($id, Request $request){
       $producto = Producto::findOrFail($id);

       if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('images', 'public');
        $producto ->update([
            'nombre'=> $request->input('nombre'),
            'u_medida'=> $request->input('u_medida'),
            'photo'=> $path
        ]);
        }else{
            $producto->update($request->all());
        }
    
       return redirect()->route('productos.index', ['productos'=>$producto]);
    }

    public function destroy(Producto $producto){
      $producto->delete();
      return redirect()->route('productos.index');
    }
    public function index(){
        $producto= Producto::all();
        return view ('productos.index', ['productos'=>$producto]);
    }
}
