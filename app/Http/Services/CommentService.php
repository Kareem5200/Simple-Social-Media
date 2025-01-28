<?php
namespace App\Http\Services;

use App\Http\Repositories\CommentRepository;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\SharedPost;
use Exception;

class CommentService{

    public function __construct(public CommentRepository $comment_repository)
    {

    }

    private $comments_morphs = [
        'shared_post'=>SharedPost::class,
        'post'=>Post::class,
    ];

    public function create($data,$commentable_type,$commentable_id){
        if(array_key_exists($commentable_type,$this->comments_morphs)){
            $commentable = $this->comment_repository->getCommentable($this->comments_morphs[$commentable_type],$commentable_id);
            $data['user_id'] =auth()->id();
            return  $this->comment_repository->create($commentable , $data);
        }
        throw new Exception('undefined post');
    }

    public function get(int $id){
        return $this->comment_repository->get($id);
    }

    public function getWithLikes(int $id){
        return new CommentResource($this->comment_repository->getWithLikes($id));
    }


    public function delete(object $comment){
        return $this->comment_repository->delete($comment);
    }

    public function update(object $comment,array $data){
        return $this->comment_repository->update($comment,$data);

    }






}
