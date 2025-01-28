<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SharePostController;

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
        Route::post('/update-bio','updateBio');
        Route::post('/update-image','updateProfileImage');
        Route::post('/update-password','updatePassword');
    });

    Route::controller(PostController::class)->group(function(){

        Route::post('create-textPost','createTextPost');
        Route::post('create-imagePost','createImagePost');
        Route::get('get-post/{id}','getPost');
        Route::delete('delete-post/{id}','forceDeletePost');
        Route::post('update-textPost/{id}','updateTextPost');
        Route::post('convert-textToImagePost/{id}','convertTextToImagePost');
        Route::post('update-imagePost/{id}','updateImagePost');
        Route::post('convert-ImageToTextPost/{id}','convertMediaToTextPost');
        Route::delete('make-onlyMe/{id}','makeOnlyMePost');
        Route::post('remove-onlyMe/{id}','removeOnlyMeOnPost');



    });

    Route::controller(LikeController::class)->group(function(){
        Route::post('like/{likeable_type}/{likeable_id}','create');
        Route::delete('unlike/{id}','delete');
    });

    Route::controller(SharePostController::class)->group(function(){
        Route::post('share-post/{id}','create')->middleware('checkPostID');
        Route::delete('delete-share-post/{id}','delete');
        Route::patch('update-share-post/{id}','update');
        Route::get('get-share-post/{id}','get');
        Route::get('get-share-posts/{user_id}','getUserPosts');
    });

    Route::controller(CommentController::class)->group(function(){
        Route::post('create-comment/{commentable_type}/{commentable_id}','create');
        Route::get('get-comment/{id}','get');
        Route::patch('update-comment/{id}','update');
        Route::delete('delete-comment/{id}','delete');
    });


});


