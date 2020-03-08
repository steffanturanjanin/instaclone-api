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


Route::prefix('auth')->group(function () {
   Route::post('login', 'AuthController@login');
   Route::post('signup', 'AuthController@signup');

   Route::middleware(['auth:api'])->group(function () {
       Route::post('logout', 'AuthController@logout');
       Route::get('user', 'AuthController@user');
   });
});


Route::middleware(['auth:api'])->group(function () {
    Route::get('users/{id}', 'UserController@index');

    Route::delete('likes', 'LikeController@destroy');
    Route::post('likes', 'LikeController@store');

    Route::post('photos', 'PhotoController@store');
    Route::get('photos', 'PhotoController@index');

    Route::post('comments', 'CommentController@store');

    Route::get('photos/{id}/comments', 'CommentController@index');

    Route::get('photos/{photo_id}/likes', 'LikeController@index');
    Route::get('photos/{photo_id}/likes/user', 'LikeController@show');

});
