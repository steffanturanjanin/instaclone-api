<?php

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

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
    return response()->json(new UserResource($request->user()));
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
    Route::get('users/followers', 'UserController@getFollows');
    Route::post('users/followings', 'UserController@follow');
    Route::get('users/followings', 'UserController@getFollowings');
    Route::get('users/followings', 'UserController@getFollowings');
    Route::delete('users/followings', 'UserController@deleteFollowings');
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
