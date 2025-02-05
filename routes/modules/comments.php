<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;


Route::controller(CommentController::class)->group(function(){
    Route::post('create-comment/{commentable_type}/{commentable_id}','create');
    Route::get('get-comment/{id}/{notification_id}','get');
    Route::patch('update-comment/{id}','update');
    Route::delete('delete-comment/{id}','delete');
});
