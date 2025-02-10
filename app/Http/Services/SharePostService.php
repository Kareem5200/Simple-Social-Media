<?php

namespace App\Http\Services;

use App\Models\SharedPost;
use App\Http\Resources\SharedPostResource;
use App\Http\Repositories\SharePostRepository;
use App\Notifications\Post\PostOwnerNotification;
use App\Notifications\Post\SharePostNotification;

class SharePostService{
    public function __construct(public SharePostRepository $sharePost_repository)
    {

    }

    public function create(array $data,$friend_service,$post_service,$notification_service,int $post_id){
       $user = auth()->user();

        $shared_post =  $this->sharePost_repository->create(array_merge($data,[
            'user_id'=>auth()->id(),
            'post_id'=>$post_id,
        ]));

        $main_post_owner = $post_service->getPostOwner($post_id);

        $friends = $friend_service->getFriends($user->id,['id'])->reject(function($friend) use ($main_post_owner){

            return  $friend->id == $main_post_owner->id;
        });

        $main_post_owner->id == $user->id ? : $notification_service->sendNotificationToUser($main_post_owner,new PostOwnerNotification($user,$shared_post->id));
        $notification_service->sendNotificationToFriends($friends,new SharePostNotification($user,$shared_post->id));

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


    public function getWithPostResource(int $id,$notification_id,$notification_service){
        $notification_service->markAsRead($notification_id);
        return new SharedPostResource($this->sharePost_repository->getWithPost($id));
    }



    public function getSharedPosts(array $user_id,$pagination_number = 15){

        $posts = $this->sharePost_repository->getUserSharedPosts($user_id,$pagination_number);
        return  $posts->isEmpty() ? null : $posts;

    }

    public function mapPaginatedSharedPosts($posts){
        return $posts->through(function ($post) {
            return [
                'type' => "shared-post",
                'content' => new SharedPostResource($post),
            ];
        });
    }


}
