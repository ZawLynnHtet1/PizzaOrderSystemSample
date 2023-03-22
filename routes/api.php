<?php

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\API\APIController;
use App\Http\Controllers\AuthApiController;

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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('/register',[AuthApiController::class,'register']);

Route::post('/login',[AuthApiController::class,'apilogin']);

Route::group(['prefix'=>'category','middleware'=>'auth:sanctum'], function(){

    Route::get('/list',[APIController::class,'categoryList']);

    Route::post('/create',[APIController::class,'categoryCreate']);

    Route::post('/detail',[APIController::class,'detail']);

    Route::get('/delete/{id}',[APIController::class,'delete']);

    Route::post('/update/{id}',[APIController::class,'update']);

    Route::get('/logout',[APIController::class,'logout']);


});
Route::group(['middleware'=>'auth:sanctum'], function(){


    Route::get('/logout',[AuthApiController::class,'logout']);


});
