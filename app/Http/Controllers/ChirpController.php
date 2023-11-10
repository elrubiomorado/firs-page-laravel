<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Devolver vista del chirp
        return view("chirps.index",[
            "chirps" => Chirp::with("user")->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validamos
        $validate = $request->validate([
            "message" => ["required", "min:10", "max: 255"]
        ]);
        
        $request->user()->chirps()->create($validate);


        return to_route("chirps.index")->with("status", __("Chirp created successfully!"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {

        //Verificamos que el chirp sea del usuario auntenticado
        $this->authorize("update", $chirp);
        //Retornamos la vista en la que edita los chirps
        return view("chirps.edit", [
            "chirp"=>$chirp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        //Verificamos que el chirp sea del usuario auntenticado
        $this->authorize("update", $chirp);
        //Validamos
        $validate = $request->validate([
            "message" => ["required", "min:10", "max: 255"]
        ]);
        //update datos
        $chirp->update($validate);
        //Retornamos a la vista index del chirp
        return to_route("chirps.index")->with("status", __("Chirp updated succesfully!"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        //autorizamos que podemos eliminar el chirp
        $this->authorize("delete", $chirp);

        //Eliminamos el chirp
        $chirp -> delete();
        
        return to_route("chirps.index")->with("status", __("Chirp deleted succesfully!"));

    }
}
