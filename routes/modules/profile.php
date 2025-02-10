<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


Route::controller(ProfileController::class)->group(function(){
        Route::get('/profile/{user_id}','profile');
        Route::post('/update-profile','updateprofile');
        Route::post('/update-image','updateProfileImage');
        Route::post('/update-password','updatePassword');
    });
