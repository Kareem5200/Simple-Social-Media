<?php
namespace App\Http\Repositories;

use App\Models\Post;
use App\Models\User;
use App\Models\TextPost;
use App\Models\MediaPost;

class PostRepository{

    public function createPost(object $post_type){
        return $post_type->post()->create([
            'user_id'=>auth()->id(),
        ]);
    }

    public function createTextPost(array $data){
        return  TextPost::create($data);
        // return  $this->createPost($text_post);

    }

    public function createMediaPost(array $data){
        return  MediaPost::create($data);
        // return  $this->createPost($image_post);
    }

    public function updatePost(Post $post,array $data){
        return $post->postable()->update($data);
    }


    //get post with comments and likes
    //receive id to make eager loading to get post and their data
    public function getPost(int $id){
        return  Post::postData()->findOrFail($id);
    }

    public function getPostWithoutData(int $id){
        return  Post::findIOrFail($id);
    }




    //All posts for specific user to use in user profile
    public function getUserPosts(User $user){
        return $user->posts()->postData()->orderBy('created_at', 'desc')->paginate();
    }

    //Delete post with all comments and likes
    public function forceDeletePost(Post $post){
        return $post->forceDelete();
    }


    //make soft deletes
    public function softDeletePost(Post $post){
        return $post->delete();
    }

    public function getTrashedPost(int $id){
        return Post::onlyTrashed()->findOrFail($id);
    }



    //soft deletes
    public function restoreSoftDeletedPost(Post $post){
        return $post->restore();
    }









}
