<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\authenticate\authenticateController;
use App\Http\Controllers\api\data\dataController;
use App\Http\Controllers\api\comment\commentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace'=>'api','prefix'=>'api'],function(){
    Route::group(['namespace'=>'authenticate','prefix'=>'authenticate'],function(){
        Route::post('/register', [authenticateController::class, 'register']);
        Route::post('/login', [authenticateController::class, 'login']);
    });

    Route::group(['namespace'=>'data','prefix'=>'data'],function(){
        Route::post('/create', [dataController::class, 'create']);
        Route::post('/update', [dataController::class, 'update']);
        Route::post('/delete', [dataController::class, 'delete']);
        Route::get('/list/{token}', [dataController::class, 'list']);
        Route::get('/detail/{token}/{dataId}', [dataController::class, 'detail']);
    });

    Route::group(['namespace'=>'comment','prefix'=>'comment'],function(){
        Route::post('/create', [commentController::class, 'create']);
        Route::post('/update', [commentController::class, 'update']);
        Route::post('/delete', [commentController::class, 'delete']);
      
    });

});