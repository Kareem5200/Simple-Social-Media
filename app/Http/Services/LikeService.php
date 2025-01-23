<?php
namespace App\Http\Services;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Models\SharedPost;use Exception;
use App\Http\Repositories\LikeRepository;

class LikeService{

    private $like_morphs = [
        'post'=>Post::class,
        'shared_post'=>SharedPost::class,
        'comment'=>Comment::class,
    ];


    public function __construct(public LikeRepository $like_repository)
    {

    }

    public function create($likeable_type,$id){

        if(array_key_exists($likeable_type,$this->like_morphs)){

            $likeable = $this->like_repository->getLikeable($this->like_morphs[$likeable_type],$id);
            if(!$this->like_repository->checkIfExists($likeable)){
                   return  $this->like_repository->create($likeable);
                }
                throw new Exception("Like exists");
        }
        throw new Exception('Error in likeable');


    }

    public function get($id){
        return $this->like_repository->get($id);

    }

    public function delete(Like $like){
        return $this->delete($like);
    }








}
