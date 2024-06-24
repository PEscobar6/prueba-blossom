<?php

use Illuminate\Support\Facades\Route;
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
});