<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;



Route::controller(NotificationController::class)->group(function(){
    Route::get('get-notifications','get');
    Route::delete('delete-notification/{id}','delete');
});
