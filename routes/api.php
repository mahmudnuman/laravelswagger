<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Articles",
 *     description="Endpoints for managing articles"
 * )
 */

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
Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
Route::post('/logout',  'AuthController@logout')->middleware('auth:sanctum');



// Protected routes (require authentication)
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/articles', 'ArticleController@index');
    Route::post('/articles', 'ArticleController@store');
    Route::put('/articles/{article}', 'ArticleController@update');
    Route::delete('/articles/{article}', 'ArticleController@destroy');
});