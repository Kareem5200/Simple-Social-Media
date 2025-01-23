<?php
namespace App\Http\Repositories;

use App\Models\Like;
use App\Models\Post;
use App\Models\SharedPost;

class LikeRepository{

    public function create($likeable){
        return $likeable->likes()->create([
            'user_id' => auth()->id(),
        ]);

    }



    public function get(int $id){
        return Like::findOrFail($id);
    }

    public function delete(Like $like){
        return $like->delete();
    }

    public function checkIfExists($likeable){
        return $likeable->likes()->userLike()->exists();
    }

    public function getLikeable($likeable,$id){

        return $likeable::findOrFail($id);

    }




}
