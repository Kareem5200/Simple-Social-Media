<?php
namespace App\Http\Repositories;

use App\Models\Post;


class LikeRepository{

    public function create(Post $post){
        return $post->likes()->create([
            'user_id' => auth()->id(),
        ]);

    }

    public function delete(post $post){
        return $post->likes()->where('user_id',auth()->id())->delete();
    }

    public function checkIfExists(Post $post){
        return $post->likes()->where('user_id',auth()->id())->exists();
    }




}
