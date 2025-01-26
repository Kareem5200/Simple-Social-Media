<?php

namespace App\Http\Services;

use App\Http\Repositories\SharePostRepository;
use App\Http\Resources\SharedPostResource;
use App\Models\SharedPost;

class SharePostService{
    public function __construct(public SharePostRepository $sharePost_repository)
    {

    }

    public function create(array $data,int $post_id){
        $data = array_merge($data,[
            'user_id'=>auth()->id(),
            'post_id'=>$post_id,
        ]);

        return $this->sharePost_repository->create($data);

    }


    public function delete(SharedPost $shared_post){
        return $this->sharePost_repository->delete($shared_post);
    }

    public function update(SharedPost $shared_post,array $data){
        return $this->sharePost_repository->update($shared_post,$data);
    }

    public function get(int $id){
        return $this->sharePost_repository->get($id);
    }

    // public function getWithPost(int $id){
    //     return $this->sharePost_repository->getWithPost($id);
    // }

    public function getWithPostResource(int $id){
        return new SharedPostResource($this->sharePost_repository->getWithPost($id));
    }

    public function getUserPostsResource($user_id){

        $user_posts = $this->sharePost_repository->getUserPosts($user_id);

        if ($user_posts->isEmpty()) {
                return null;
            }

        return $user_posts->count() > 1
                ? SharedPostResource::collection($user_posts)
                : new SharedPostResource($user_posts->first());
        }

}
