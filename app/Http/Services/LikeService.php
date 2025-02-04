<?php
namespace App\Http\Services;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Models\SharedPost;use Exception;
use App\Http\Repositories\LikeRepository;
use App\Notifications\Like\MakeLikeNotification;

class LikeService{

    private $like_morphs = [
        'post'=>Post::class,
        'shared-post'=>SharedPost::class,
        'comment'=>Comment::class,
    ];


    public function __construct(public LikeRepository $like_repository)
    {

    }

    public function create($notification_service,$likeable_type,$likeable_id){


        array_key_exists($likeable_type,$this->like_morphs)?:throw new Exception('Error in likeable');

        $likeable = $this->like_repository->getLikeable($this->like_morphs[$likeable_type],$likeable_id);

        !$this->like_repository->checkIfExists($likeable)?:throw new Exception('Like exists');

        $user = auth()->user();
        $likeable_owner = $likeable->user;
        $this->like_repository->create($likeable);
        $user->id == $likeable_owner->id ?:$notification_service->sendNotificationToUser($likeable_owner,new MakeLikeNotification($user,$likeable_type,$likeable_id,));

    }

    public function get($id){
        return $this->like_repository->get($id);

    }

    public function delete(Like $like){
        return $this->like_repository->delete($like);
    }








}
