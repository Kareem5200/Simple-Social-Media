<?php
namespace App\Http\Services;

use App\Http\Repositories\FriendRepository;

class FriendService{

    public function __construct(public FriendRepository $friend_repository)
    {

    }

}
