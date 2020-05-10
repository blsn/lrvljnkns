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

Route::get('posts', 'API\PostsController@index'); // list posts
Route::get('post/{id}', 'API\PostsController@show'); // list single post
Route::post('post', 'API\PostsController@store'); // create new post
Route::put('post', 'API\PostsController@store'); // update post
Route::delete('post/{id}', 'API\PostsController@destroy'); // delete post