<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendController;


Route::controller(FriendController::class)->group(function(){

    Route::post('add-friend/{friend_id}','addFriend');
    Route::patch('accept-friend/{user_id}/{notification_id}','acceptFriendRequest');
    Route::delete('delete-friendRequest/{user_id}/{notification_id}','deleteReceivedFriendRequest');
    Route::delete('cancel-sentRequest/{friend_id}','cancelSentFriendRequest');
    Route::delete('unfriend/{friend_id}','unfriend');
    Route::get('get-friends/{user_id}','getFriends');
    Route::get('get-suggestedFriends','getSuggestedFriends');



});
