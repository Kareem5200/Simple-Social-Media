<?php


namespace nApp\Http\Services;

use App\Http\Repositories\LikeRepository;
use App\Http\Services\PostService;
use Exception;

class LikeService{

    public function __construct(public LikeRepository $like_repository)
    {

    }

    public function create($post_service,int $post_id){
        
        $post = $post_service->getPostWithoutData($post_id);
        if(!$this->like_repository->checkIfExists($post)){
            throw new Exception("Like exists");
        }
        $this->like_repository->create($post);

    }

    public function delete(){

    }




}
