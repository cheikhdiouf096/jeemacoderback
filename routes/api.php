<?php

use App\Http\Controllers\Api\hackathonController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\FeedbackController;
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



// Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);


Route::middleware('auth:sanctum')->group(function ()
{
    Route::get('/user', function (Request $request) {
        return $request->user();});
    Route::get('/users', [UserController::class,'index']);
    Route::post('/logout',[UserController::class, 'logout']);
    Route::post('/hackathons/create',[hackathonController::class, 'store']);
    Route::get('/hackathons',[hackathonController::class,'index']);
    Route::get('/hackathon/{id}',[hackathonController::class,'show']);
    Route::put('/hackathons/update/{hackathon}',[hackathonController::class,'update']);
    Route::delete('/hackathons/delete/{hackathon}',[hackathonController::class,'destroy']);


    //Route pour les feedback ;
    Route::post('/create',[FeedbackController::class, 'store']);
    Route::get('/feedback', [FeedbackController::class, 'index']);
    Route::get('/feedback/{id}', [FeedbackController::class, 'show']);
    Route::put('/feedback/update{id}', [FeedbackController::class, 'update']);
    Route::delete('/feedback/delete{id}', [FeedbackController::class, 'destroy']);

    ;});





