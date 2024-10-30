<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Caracteristica;
use App\Models\Categoria;
use Exception;
use DB;

class categoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $categorias = Categoria::with('caracteristica')->latest()->get();

        return view('categoria.index',['categorias' => $categorias]);
    }

    public function create()
    {
        return view('categoria.create');
    }

    public function store(StoreCategoriaRequest $request) 
    {
        //dd($request);
        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->categoria()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }

        return redirect()->route('categorias.index')->with('success','Categoria Registrada');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('categoria.edit', ['categoria'=>$categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        Caracteristica::where('id',$categoria->caracteristica->id)
        ->update($request->validated());

        return redirect()->route('categorias.index')->with('success','Categoria editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $categoria = Categoria::find($id);
        if($categoria->caracteristica->estado ==1){
            Caracteristica::where('id',$categoria->caracteristica->id)
            ->update([
                'estado' => 0
            ]);
            $message = 'Categoria eliminada';
        }else{
            Caracteristica::where('id',$categoria->caracteristica->id)
            ->update([
                'estado' => 1
        ]);
            $message = 'Categoria restaurada';
        }

        return redirect()->route('categorias.index')->with('success',$message);
    }
}
