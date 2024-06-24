<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CharactersController;
use App\Http\Controllers\api\EpisodesController;
use App\Http\Controllers\api\UsersController;

Route::get('/health', function () {
    return response()->json([
        'message' => 'Welcome to the Rick and Morty API',
        'status' => 200
    ], 200);
});

Route::post('/login', [UsersController::class, 'login']);

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UsersController::class, 'index']);
        Route::get('/{id}', [UsersController::class, 'show']);
        Route::post('/', [UsersController::class, 'store']);
        Route::put('/{id}', [UsersController::class, 'update']);
        Route::patch('/{id}', [UsersController::class, 'updatePartial']);
        Route::delete('/{id}', [UsersController::class, 'destroy']);
    });
    Route::group(['prefix' => 'episodes'], function () {
        Route::get('/', [EpisodesController::class, 'index']);
        Route::get('/{id}', [EpisodesController::class, 'show']);
        Route::post('/', [EpisodesController::class, 'store']);
        Route::put('/{id}', [EpisodesController::class, 'update']);
        Route::patch('/{id}', [EpisodesController::class, 'updatePartial']);
        Route::delete('/{id}', [EpisodesController::class, 'destroy']);
    });
    Route::group(['prefix' => 'characters'], function () {
        Route::get('/', [CharactersController::class, 'index']);
        Route::get('/{id}', [CharactersController::class, 'show']);
        Route::post('/', [CharactersController::class, 'store']);
        Route::put('/{id}', [CharactersController::class, 'update']);
        Route::patch('/{id}', [CharactersController::class, 'updatePartial']);
        Route::delete('/{id}', [CharactersController::class, 'destroy']);
    });
});