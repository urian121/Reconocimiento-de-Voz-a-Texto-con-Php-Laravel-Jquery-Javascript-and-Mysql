<?php

use Illuminate\Support\Facades\Route;
use App\NombrePaises;
/*
|--------------------------------------------------------------------------
| Hacer una consulta en el mismo route sin necesidad de acudir a un controlador
|--------------------------------------------------------------------------
|
Route::get('notas/{id}/editar', function ($id) {
    $note = DB::table('notes')
        ->where('id', $id)
        ->first();

    return ['note' => $note];
})->name('notes.edit');

*/

/*Route::get('/', function () {
    return view('home');
}); */

//Route::get('palabras/url', 'NombrePaisesController@url')->name('ruta');
Route::get('/', 'NombrePaisesController@url')->name('ruta');
Route::post('palabras/vozData', 'NombrePaisesController@vozData')->name('palabra');
Route::get('palabras/data', 'NombrePaisesController@mostrarData')->name('midata');
Route::get('palabras/buscar', 'NombrePaisesController@buscarpalabra')->name('searchData');  //buscar




/*{{json_decode($leads)}}
 Route::get('usuarios/crear', 'UserController@create')
    ->name('users.create'); */


/*
Route::('',function(){
$nombres = NombrePaises::all();
return view('home', compact('nombres'));
}); */
/*

Route::get('respuesta/json', function(){
  $data = array("title1","title2","title3");
  return Response::json($data);
});


Route::get('usuarios', [
  'uses' => 'UserController@index',
  'as' => 'users.index'
]);/*
