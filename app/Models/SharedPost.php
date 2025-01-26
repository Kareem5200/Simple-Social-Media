<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SharedPost extends Model
{
    use HasFactory;

    public $table='shared_posts';

    protected $fillable=[
        'caption',
        'user_id',
        'post_id',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function post(){
        return $this->belongsTo(Post::class,'post_id')->with(['user:id,name,profile_image','postable','comments.user:id,name,profile_image','likes.user'])->withCount(['comments','likes']);
    }

    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }

    public function likes(){
        return $this->morphMany(Like::class,'likeable');
    }

    public function savedPosts(){
        return $this->morphMany(SavedPost::class,'saveable');
    }

    public function scopeSharedPostData($builder){
        return $builder->with([
        'user:id,name,profile_image',
        'likes',
        'likes.user:id,name,profile_image',
        'comments',
        'comments.user:id,name,profile_image',
        'comments.likes',
        'comments.likes.user:id,name,profile_image',
        'post'=>function($post){
        $post->postData();
        },
        ])->withCount(['comments','likes']);
    }


    protected static function boot(){

        parent::boot();

        static::deleting(function($shared_post){
            DB::transaction(function ()use($shared_post) {
                $shared_post->likes()->delete();
                $shared_post->comments()->delete();
            });
        });

    }

}
