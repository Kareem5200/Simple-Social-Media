<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


Route::controller(PostController::class)->group(function(){

    Route::post('create-textPost','createTextPost');
    Route::post('create-imagePost','createImagePost');
    Route::get('get-post/{id}/{notification_id?}','getPost');
    Route::delete('delete-post/{id}','forceDeletePost');
    Route::post('update-textPost/{id}','updateTextPost');
    Route::post('convert-textToImagePost/{id}','convertTextToImagePost');
    Route::post('update-imagePost/{id}','updateImagePost');
    Route::post('convert-ImageToTextPost/{id}','convertMediaToTextPost');
    Route::delete('make-onlyMe/{id}','makeOnlyMePost');
    Route::post('remove-onlyMe/{id}','removeOnlyMeOnPost');



});
