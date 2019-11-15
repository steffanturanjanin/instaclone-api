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

/*Route::middleware('cors')->group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::middleware('auth:api')->group(
        function () {
            Route::get('logout', 'AuthController@logout');
            Route::get('user', 'AuthController@user');
        });
});*/

Route::prefix('auth')->group(function () {
   Route::post('login', 'AuthController@login');
   Route::post('signup', 'AuthController@signup');

   Route::middleware(['auth:api'])->group(function () {
       Route::get('logout', 'AuthController@logout');
       Route::get('user', 'AuthController@user');
   });
});

/*Route::middleware(['auth:api'])->group(function () {
    Route::post('photo', 'PhotoController@store');
});*/

Route::post('photo', 'PhotoController@store');
Route::get('photo', 'PhotoController@index');

Route::get('photo/{id}/comment', 'CommentController@index'); //change this to comment/photo/{id}

Route::get('user/{id}', 'UserController@index');


Route::delete('like', 'LikeController@destroy');
Route::post('like', 'LikeController@store');
Route::get('like/{photo_id}', 'LikeController@index');
Route::get('like/photo/{photo_id}/user/{user_id}', 'LikeController@show');

Route::post('comment', 'CommentController@store');

/*Route::group([
    'prefix' => 'auth'
], function () {
   Route::post('login', 'AuthController@login');
   Route::post('signup', 'AuthController@signup');

   Route::group([
       'middleware' => 'auth:api'
       ], function () {
       Route::get('logout', 'AuthController@logout');
       Route::get('user', 'AuthController@user');
   });
});*/
