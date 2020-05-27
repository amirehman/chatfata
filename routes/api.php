<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route::post('/recipes/images/{collection}/{recipeid}/{recipename}', 'RecipeController@storeImages');
    Route::resource('/recipes', 'RecipeController');
    Route::post('/steps', 'PreparationController@store');
    Route::delete('/steps/{step}', 'PreparationController@delete');
    Route::patch('/steps/{step}', 'PreparationController@update');

    Route::post('/ingredients', 'IngredientController@store');
    Route::delete('/ingredients/{ingredient}', 'IngredientController@delete');
    Route::patch('/ingredients/{ingredient}', 'IngredientController@update');

    Route::post('/recipes/images/{collection}/{recipeid}/{recipename}', 'MediaController@storeImages');
    Route::delete('/media/{image}', 'MediaController@deleteImage');

});
