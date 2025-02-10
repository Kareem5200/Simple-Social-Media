<?php

use App\Http\Controllers\TimelineController;
use Illuminate\Support\Facades\Route;

Route::controller(TimelineController::class)->group(function(){
    Route::get('/timeline','timeline');
});
