<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(Post::class,'post_id');
    }

    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }

    public function likes(){
        return $this->morphMany(Like::class,'likable');
    }
}
