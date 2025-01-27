<?php
namespace App\Http\Repositories;

use App\Models\Comment;

class CommentRepository{


    public function create(object $commentable ,array $data){
        return $commentable->comments()->create($data);
    }

    public function getCommentable($model , int $id){
        return $model::findOrFail($id);
    }

    public function get(int $id){
        return Comment::findOrFail($id);
    }

    public function getWithLikes(int $id){
        return Comment::with(['likes:id,user_id','likes.user:id,name,profile_image'])->withCount('likes')->findOrFail($id);
    }


    public function delete($comment){
        return $comment->delete();
    }

    public function update($comment,array $data){
        return $comment->update($data);
    }



}
