<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CharactersController;
use App\Http\Controllers\api\EpisodesController;

Route::group(['prefix' => 'v1'], function () {
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