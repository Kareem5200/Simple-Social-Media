<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;

Route::controller(LikeController::class)->group(function(){
    Route::post('like/{likeable_type}/{likeable_id}','create');
    Route::delete('unlike/{id}','delete');
});
