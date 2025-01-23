<?php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\User;
use App\Models\TextPost;
use App\Models\MediaPost;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use App\Http\Repositories\PostRepository;
use Exception;
use PHPUnit\Event\Code\Throwable;

class PostService{

     public function __construct(public PostRepository $post_repository) {

    }

    //in create use Notification for friends
    public function createTextPost(array $data){
        $text_post = $this->post_repository->createTextPost($data);
        return  $this->post_repository->createPost($text_post);
       //Send notification for friends
    }

    public function CreateImagePost(array $data){

        $data = checkUploadedFile($data,'content','/public/posts/image');

        if($data){
            $media_post =  $this->post_repository->createMediaPost($data);
            return  $this->post_repository->createPost($media_post);
        }

        throw new Exception('Error in uploading file');


    }

    //get post with all comments and likes
    //receive id to make eager loading to get post and their data
    public function getPost(int $id){
        return $this->post_repository->getPost($id);
    }

    //Add the user posts in resource
    public function getUserPosts(User $user){
        return PostResource::collection($this->post_repository->getUserPosts($user));
    }

    //Add specific post in resource
    public function getPostResource(int $id){
        return new PostResource($this->getPost($id));
    }

    public function getPostWithoutData($id,bool $trashed = false){
        if($trashed){

            return $this->post_repository->getTrashedPost($id);

        }
        return $this->post_repository->getPostWithoutData($id);
    }



    //Update the content of text post
    public function updateTextPost(Post $post ,array $data){

        if($post->postable instanceof TextPost){

            return $this->post_repository->updatePost($post,$data);
        }
            throw new Exception('Error in post type');


    }

    //Remove the image of the post and make it text post only
    public function convertTextToImagePost(Post $post ,array $data){

        if($post->postable instanceof TextPost){

            $data = checkUploadedFile($data,'content','/public/posts/image');
            if($data){
                DB::transaction(function ()use($post,$data) {

                    $media_post = $this->post_repository->createMediaPost($data);
                    $post->postable()->delete();
                    $post->postable()->associate($media_post);
                    $post->save();

                });
                return true;
            }

            throw new Exception('Error in uploading file') ;
        }
            throw new Exception('Error in post type') ;



    }

    //update the image or content  of the image post
    public function updateImagePost(Post $post ,array $data){

        if($post->postable instanceof MediaPost && $post->postable->type == 'image' ){

            $data = checkUploadedFile($data,'content','/public/posts/image');
            if($data){
                return $this->post_repository->updatePost($post,$data);
            }
            throw new Exception('Error in updating'); ;
        }

        throw new Exception('Error in post type') ;

    }

    public function convertMediaToTextPost(Post $post , array $data){

        if($post->postable instanceof MediaPost){

            DB::transaction(function () use($post,$data) {
                $text_post = $this->post_repository->createTextPost($data);
                $post->postable()->delete();
                $post->postable()->associate($text_post);
                $post->save();
            });

            return true;
        }
        throw new Exception('Error in post type') ;


    }


    //Use Force delete
    public function deletePost(Post $post){
        return $this->post_repository->forceDeletePost($post);
    }


    public function makeOnlyMePost(Post $post){
        return $this->post_repository->softDeletePost($post);
    }

    public function RemoveOnlyMeOnPost(Post $post){
        return $this->post_repository->restoreSoftDeletedPost($post);
    }









}
