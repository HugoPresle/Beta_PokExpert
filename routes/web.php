<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\PokemonController;

use App\Http\Controllers\HomeController;




/**********           SIMPLE ROUTE            **********/
Route::get('/', function () {return view('home');});
Route::get('/home', function () {return view('home');});
Route::get('/my_list', function () {return view('/list/my_list');});


/**********           ADMIN            **********/
Route::get('/admin',[PokemonController::class, 'admin']);
Route::post('/update_admin/{id}',[PokemonController::class, 'update_admin']);


/**********           UTILS ROUTE            **********/
Auth::routes();
Route::get('/autocomplete', [PokemonController::class, 'autocompleteSearch'])->name('autocomplete');



/**********           POKEDEX           **********/
Route::get('/pokedex', [PokemonController::class,'loadAllOrderById']);
Route::get('/pokedex/gen/{Id}', [PokemonController::class,'loadAllByGen']);
Route::get('/pokedex/{name}',[PokemonController::class,'loadAllByName']);



/**********           POKEMON           **********/
Route::get('/create',[PokemonController::class,'getType']);
Route::get('/update/{Id}',[PokemonController::class,'loadById']);

Route::post('/create_pokemon',[PokemonController::class,'create']);
Route::post('/update_pokemon/{Id}',[PokemonController::class,'update']);
Route::post('/delete_pokemon/{page}/{Id}',[PokemonController::class,'delete']);



/**********           LIST           **********/
Route::get('/create-list', [PokemonController::class,'load']);
Route::post('/create_list', [PokemonController::class,'create_list']);

Route::get('/modify-list/{Id}', [PokemonController::class,'modifyListById']);
Route::post('/modify_list/{Id}', [PokemonController::class,'modify_list']);


Route::get('/list',[PokemonController::class, 'loadPublicList']);
Route::get('/list/{Id}',[PokemonController::class, 'loadListById']);

Route::post('/update_list/{Id}', [PokemonController::class,'update_list']);
Route::post('/delete_list/{test}/{Id}', [PokemonController::class,'delete_list']);


/**********           PROFILE           **********/
Route::get('/profile', function () {return view('profile');});
Route::get('/profile/{Name}', [PokemonController::class,'getProfile']);
Route::post('/update_profile/{Id}', [PokemonController::class,'update_profile']);


/**********           STATS            **********/

Route::get('/statistics',[PokemonController::class,'getStats'] );