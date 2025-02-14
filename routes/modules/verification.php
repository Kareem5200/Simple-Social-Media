<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerificationController;


Route::controller(VerificationController::class)->group(function(){

    Route::get('/verify-send','sentVerificationNotification');
    Route::post('/verify-mark/{id}/{hash}','verify')->middleware('signed')->name('verify');


});
