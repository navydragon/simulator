<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\LessonController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/admin/courses', CourseController::class);
    Route::apiResource('/admin/modules', ModuleController::class);
    Route::apiResource('/admin/lessons', LessonController::class);
});
