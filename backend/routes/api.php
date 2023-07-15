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

Route::GET('get-categories',[App\Http\Controllers\API\CommanController::class,'getAllCategory']);
Route::GET('subcategories/{category_id}',[App\Http\Controllers\API\CommanController::class,'getSubcategories']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
