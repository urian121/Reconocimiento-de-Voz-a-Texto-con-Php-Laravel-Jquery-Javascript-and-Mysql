<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\NombrePaises;
use Illuminate\Http\Request;

class NombrePaisesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function mostrarData()
    {

        $nombrePalabras = NombrePaises::orderBy('id', 'DESC')->get();
        return response()->json($nombrePalabras);
    }

    public function url()
    {
       return view('palabras.addPalabra');
    }



    public function vozData(Request $request){
        //$products=DB::table('products')->where('title','LIKE','%'.$request->search."%")->get();

    if($request->ajax()){
        $Palabra = new NombrePaises();

        $Palabra->speechToText  = $request->speechToText;
        $Palabra->created_at  =  Carbon::now();

        $Palabra->save();

    /****CONSULTAR REGISTROS***/
    $nombrePalabras = NombrePaises::orderBy('id', 'DESC')->get();
    return response()->json($nombrePalabras);
    //return response()->json($nombrePalabras->toArray());

  /*  $nombrePalabras = NombrePaises::all();
    return response()->json($nombrePalabras); */


   /* return response()->json([
        'totalpalabras'=> $nombrePalabras
    ]); */

    }
}


    public function buscarpalabra(Request $request)
    {

        if($request->ajax()){

            $palabra = $request->speechToText;
           // $searchpalabra = DB::table('nombre_paises')->where('speechToText','LIKE','%'.$palabra."%")->get();  //FUNCIONA PERFECTAMENTE
            // return response()->json($searchpalabra);

           $searchpalabra = NombrePaises::query()
               ->where('id', 'LIKE', "%{$palabra}%")
               ->orWhere('speechToText', 'LIKE', "%{$palabra}%")
               ->get();

            return response()->json($searchpalabra);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NombrePaises  $nombrePaises
     * @return \Illuminate\Http\Response
     */
    public function show(NombrePaises $nombrePaises)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NombrePaises  $nombrePaises
     * @return \Illuminate\Http\Response
     */
    public function edit(NombrePaises $nombrePaises)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NombrePaises  $nombrePaises
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NombrePaises $nombrePaises)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NombrePaises  $nombrePaises
     * @return \Illuminate\Http\Response
     */
    public function destroy(NombrePaises $nombrePaises)
    {
        //
    }
}
