<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable=[
        'user_id',

    ];



    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }

    public function likes(){
        return $this->morphMany(Like::class,'likeable');
    }



    public function sharedPosts(){
        return $this->hasMany(SharedPost::class,'post_id');
    }


    public function savedPosts(){
        return $this->morphMany(SavedPost::class,'saveable');
    }

    public function postable(){
        return $this->morphTo();
    }

    public function scopePostData($builder){
        return $builder->with([
        'user:id,name,profile_image',
        'postable',
        'comments',
        'comments.user:id,name,profile_image',
        'comments.likes',
        'likes.user:id,name,profile_image'
        ])->withCount(['comments','sharedPosts','likes']);
    }

    protected static function boot()
    {
        parent::boot();

        //Actions before deleting the any post
        static::deleting(function ($post) {

            DB::transaction(function () use ($post) {
                $post->comments()->delete();
                $post->likes()->delete();
                $post->postable()->delete();

                $post->savedPosts()->delete();
            });
        });
    }




}
