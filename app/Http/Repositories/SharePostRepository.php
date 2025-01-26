<?php
namespace App\Http\Repositories;

use App\Models\SharedPost;

class SharePostRepository{

    public function create(array $data){
        return SharedPost::create($data);
    }

    public function delete(SharedPost $shared_post){
        return $shared_post->delete();
    }

    public function update(SharedPost $shared_post,array $data){
        return $shared_post->update($data);
    }



    public function get(int $id){
        return SharedPost::findOrFail($id);
    }

    public function getWithPost(int $id){
        return SharedPost::sharedPostData()->findOrFail($id);
    }

    public function getUserPosts($user_id){
        return SharedPost::sharedPostData()->where('user_id',$user_id)->get();
    }

}
