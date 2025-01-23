<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register',[RegisterController::class,'register'])->middleware('guest');

Route::controller(LoginController::class)->group(function(){
    Route::post('/login','login')->middleware('guest');
    Route::post('/logout','logout')->middleware('auth');
});

Route::controller(VerificationController::class)->middleware(['auth','throttle:3,1'])->group(function(){

    Route::get('/verify-send','sentVerificationNotification');
    Route::get('/verify-mark/{id}/{hash}','verfiy')->middleware('signed')->name('verification.verify');

});

Route::middleware('auth')->group(function(){

    Route::controller(ProfileController::class)->group(function(){
        Route::get('/profile/{user}','profile');
        Route::post('/edit-bio','editBio');
        Route::post('/edit-image','editProfileImage');
    });

    Route::controller(PostController::class)->group(function(){

        Route::post('create-textPost','createTextPost');
        Route::post('create-imagePost','createImagePost');

        Route::middleware('checkPostID')->group(function(){
            Route::get('get-post/{id}','getPost');
            Route::delete('delete-post/{id}','forceDeletePost');
            Route::post('update-textPost/{id}','updateTextPost');
            Route::post('convert-textToImagePost/{id}','convertTextToImagePost');
            Route::post('update-imagePost/{id}','updateImagePost');
            Route::post('convert-ImageToTextPost/{id}','convertMediaToTextPost');
            Route::delete('make-onlyMe/{id}','makeOnlyMePost');
            Route::post('remove-onlyMe/{id}','removeOnlyMeOnPost');
        });


    });

    Route::controller(LikeController::class)->middleware('checkPostID')->group(function(){
        Route::post('like/{id}','create');
        Route::delete('unlike/{id}','delete');
    });


});


