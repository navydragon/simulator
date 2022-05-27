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
Route::post('/test', function (Request $request) {
    try {
        $users = DB::select($request->sql);
    } catch (Throwable $e) {
        
        return response([
            'status' => 'error',
            'error' => $e->getMessage()
        ], 500);
    }
    
    return $users;
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
