<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\StreetController;
use App\Http\Controllers\Sikoja\GaleryController;
use App\Http\Controllers\Sikoja\SikojaController;
use App\Http\Controllers\Master\VillageController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\SikojaDispotition\FileController;
use App\Http\Controllers\SikojaDispotition\SikojadispController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//sikoja
Route::get('sikoja', [SikojaController::class, 'index']);
Route::get('sikoja/{id}', [SikojaController::class, 'show']);
Route::post('sikoja', [SikojaController::class, 'store']);
Route::patch('updateStatus/{id}', [SikojaController::class, 'updateStatus']);
Route::post('uploadGalery', [GaleryController::class, 'uploadGaleries']);

//sikojadips
Route::get('sikojadisp', [SikojadispController::class, 'index']);
Route::post('sikojadisp', [SikojadispController::class, 'store']);
Route::patch('sikojadisp/{id}', [SikojadispController::class, 'update']);
Route::post('uploadFile', [FileController::class, 'uploadFiles']);


//village
Route::resource('village', VillageController::class)->except(['create', 'edit', 'destroy']);
Route::resource('street', StreetController::class)->except(['create', 'edit', 'destroy']);
Route::resource('category', CategoryController::class)->except(['create', 'edit', 'destroy']);
