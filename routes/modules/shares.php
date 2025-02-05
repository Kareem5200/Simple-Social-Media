<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SharePostController;



Route::controller(SharePostController::class)->group(function(){
    Route::post('share-post/{id}','create')->middleware('checkPostID');
    Route::delete('delete-share-post/{id}','delete');
    Route::patch('update-share-post/{id}','update');
    Route::get('get-share-post/{id}/{notification_id}','get');
    Route::get('get-share-posts/{user_id}','getUserPosts');
});
