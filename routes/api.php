<?php

use App\Http\Controllers\Api\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

//route pour CROUD de roles
Route::post('/addrole',[RoleController::class,'store']);
Route::post('/updaterole',[RoleController::class,'update']);
Route::post('/deleterole',[RoleController::class,'destroy']);
Route::get('/roles',[RoleController::class,'index']);
Route::get('/role/{id}',[RoleController::class,'show']);



Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);




