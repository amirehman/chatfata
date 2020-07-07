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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/contact', 'FormController@contact');
Route::post('/check-if-email-valide/{email}', 'AuthHelperController@isEmailValid');
Route::post('/check-if-username-valide/{username}', 'AuthHelperController@isUsernameValid');
Route::post('/register', 'RegisterController@index');

// Route::post('/password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
// Route::post('/password/reset', 'Api\ResetPasswordController@reset');



Route::middleware('auth:api')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //Forms
    Route::patch('/recipe/{recipe}/changestatus', 'RecipeController@changeStatus');
    Route::resource('/recipes', 'RecipeController');
    Route::post('/steps', 'PreparationController@store');
    Route::delete('/steps/{step}', 'PreparationController@delete');
    Route::patch('/steps/{step}', 'PreparationController@update');
    Route::patch('/order/steps/{recipeid}', 'PreparationController@updateOrder');

    Route::post('/ingredients', 'IngredientController@store');
    Route::post('/ingredients/heading', 'IngredientController@storeHeading');
    Route::delete('/ingredients/{ingredient}', 'IngredientController@delete');
    Route::patch('/ingredients/{ingredient}', 'IngredientController@update');
    Route::patch('/ingredients/{ingredient}/heading', 'IngredientController@updateHeading');
    Route::patch('/order/ingredients/{recipeid}', 'IngredientController@updateOrder');

    Route::post('/recipes/images/{collection}/{recipeid}/{recipename}', 'MediaController@storeImages');
    Route::delete('/media/{image}', 'MediaController@deleteImage');

    // channel application
    Route::post('/channels/apply', 'UserController@applyForChannel');


});

Route::get('/email/resend', 'Api\VerificationController@resend')->name('verification.resend');
