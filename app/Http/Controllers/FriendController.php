<?php

namespace App\Http\Controllers;

use App\Http\Services\FriendService;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function __construct(public FriendService $friend_service)
    {

    }
}
