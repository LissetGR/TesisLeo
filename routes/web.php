<?php

use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RealController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('productos', ProductoController::class);


});

Route::get('/estadisticas', function(){
   return view('estadisticas.estadisticas');
});
Route::get('/estadisticas',[EstadisticasController::class, 'show'])->name('estadisticas');

Route::get('/importe', [EstadisticasController::class, 'importeMensual'])->name('importe');
Route::get('/planMensual', [EstadisticasController::class, 'show'])->name('plan');
Route::get('/realMensual', [EstadisticasController::class, 'realMensual'])->name('real');
Route::get('/porcentual', [EstadisticasController::class, 'realPorcentualAnual'])->name('porcentual');

Route::resource('real', RealController::class);
Route::resource('plan', PlanController::class);


require __DIR__.'/auth.php';
