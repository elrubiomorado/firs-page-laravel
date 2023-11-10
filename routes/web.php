<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Chirp;

//Rutas
Route::get('/', function () {
    return view ('welcome');
});

//rutas en las rutas
Route::middleware('auth')->group(function () {
    Route::view('/dashboard', "dashboard")->name("dashboard");
    //Midleware, accion que sucede entre la la accion de la ruta
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get("/chirps", [ChirpController::class, "index"])->name("chirps.index");//Nombre a la ruta

    //Ruta por el metodo post
    Route::post("/chirps", [ChirpController::class, "store"])->name("chirps.store");

    //Modificar un chirp ruta
    Route::get("/chirps/{chirp}/edit", [ChirpController::class, "edit"])->name("chirps.edit");

    //Editar el chirp
    Route::put("/chirps/{chirp}", [ChirpController::class, "update"])->name("chirps.update");
    
    //Delete chirp
    Route::delete("/chirps/{chirp}", [ChirpController::class, "destroy"])->name("chirps.destroy");
});

require __DIR__.'/auth.php';
