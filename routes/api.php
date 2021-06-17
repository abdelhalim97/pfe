<?php

use Illuminate\Http\Request;

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
// Route::middleware('auth:api-moderator')->get('/moderator', function (Request $request) {
//     return $request->moderator();
// });


Route::apiResources([
    'moderator'=>'API\ModeratorController',
    'profile'=>'API\ProfileController',
    'button'=>'API\buttonController',
    'boitier'=>'API\BoitierController',
    'pole'=>'API\PoleController',
    'ampere'=>'API\AmpereController',
    'product'=>'API\ProductController',
    'user'=>'API\UserController',
    'home'=>'API\HomeController',
    'order'=>'API\OrderController',
    'worker'=>'API\WorkerController',
]);
Route::get('findOrder','API\OrderController@search');
Route::get('findWorker','API\WorkerController@search');
Route::get('findButton','API\buttonController@search');
Route::get('findBoitier','API\boitierController@search');
Route::get('findPole','API\PoleController@search');
Route::get('findAmpere','API\ampereController@search');
Route::get('findProduct','API\ProductController@search');
Route::get('findAdmin','API\ModeratorController@search');
Route::get('findUser','API\UserController@search');


// Route::group(['middleware' => 'auth:api'], function() {
// Route::apiResources([
//     'user' => 'API\UserController'
// ]);
// });
