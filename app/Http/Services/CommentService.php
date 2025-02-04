<?php
namespace App\Http\Services;

use App\Http\Repositories\CommentRepository;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\SharedPost;
use App\Notifications\comment\MakeCommentNotification;
use Exception;

class CommentService{

    public function __construct(public CommentRepository $comment_repository)
    {

    }

    private $comments_morphs = [
        'shared-post'=>SharedPost::class,
        'post'=>Post::class,
    ];

    public function create($data,$notification_service,$commentable_type,$commentable_id){
        if(!array_key_exists($commentable_type,$this->comments_morphs)){
            throw new Exception('undefined post');
        }


        $commentable = $this->comment_repository->getCommentable($this->comments_morphs[$commentable_type],$commentable_id);
        $commentable_owner = $commentable->user;
        $user = auth()->user();
        $comment = $this->comment_repository->create($commentable ,array_merge($data,[
            'user_id'=>$user->id,
        ]));

        $user->id ==  $commentable_owner->id ?: $notification_service->sendNotificationToUser($commentable_owner,new MakeCommentNotification($user,$commentable_type,$commentable_id,$comment->id));
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
