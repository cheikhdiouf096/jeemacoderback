<?php

use App\Http\Controllers\Api\hackathonController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;

use App\Http\Controllers\Api\UserController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;




Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


// Routes pour CRUD de roles
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/addtag',[TagController::class, 'store']);

    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
     Route::post('/logout', [UserController::class, 'logout']);


    Route::middleware('check.role:1')->group(function () {
        Route::put('/hackathons/update/{hackathon}', [HackathonController::class, 'update']);
        Route::delete('/hackathons/delete/{hackathon}', [HackathonController::class, 'destroy']);
        Route::post('/hackathons/create', [HackathonController::class, 'store']);
    });;

    Route::get('/hackathons', [HackathonController::class, 'index']);
    Route::get('/hackathon/{id}', [HackathonController::class, 'show']);
    Route::put('/hackathons/update/{hackathon}', [HackathonController::class, 'update']);
    Route::delete('/hackathons/delete/{hackathon}', [HackathonController::class, 'destroy']);
});
