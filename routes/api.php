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
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotificationController;
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



Route::middleware('auth')->group(function(){


    require __DIR__.'/modules/verification.php';
    require __DIR__.'/modules/timeline.php';
    require __DIR__.'/modules/profile.php';
    require __DIR__.'/modules/posts.php';
    require __DIR__.'/modules/likes.php';
    require __DIR__.'/modules/shares.php';
    require __DIR__.'/modules/comments.php';
    require __DIR__.'/modules/friends.php';
    require __DIR__.'/modules/notifications.php';
});


