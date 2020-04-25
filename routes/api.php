<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtAuthMiddleware;

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

/**
 * Auth Routes
 */
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function() {
    Route::post('register', 'AuthController@create');
    Route::post('signin', 'AuthController@signin');
    Route::post('signout', 'AuthController@signout')->middleware(['auth:api']);
    Route::get('user', 'AuthController@user')->middleware(['auth:api']);
});
/**
 * User Routes
 */
Route::group(['prefix' => 'user'], function() {
    Route::post('test', 'UserController@getTest')->middleware(['auth:api']);
    // Route::post('getInfo', 'UserController@getInfo')->middleware(JwtAuthMiddleware::class);
    Route::post('getInfo', 'UserController@getInfo');
    Route::post('account', 'UserController@account')->middleware(['auth:api']); 
    Route::post('update', 'UserController@update')->middleware(['auth:api']);
});

Route::group(['prefix' => 'profile'], function() {
    Route::post('update', 'ProfileController@update')->middleware(['auth:api']);
    Route::post('image', 'ProfileController@imageUpdate')->middleware(['auth:api']);
});

Route::group(['prefix' => 'post'], function() {
    Route::post('list', 'PostController@list');
    Route::post('create', 'PostController@create')->middleware(['auth:api']);
    Route::post('update', 'PostController@update')->middleware(['auth:api']);
    Route::post('delete', 'PostController@delete')->middleware(['auth:api']);
});

