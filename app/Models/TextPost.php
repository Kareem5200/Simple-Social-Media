<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TextPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'content'
    ];


    public function post(){
        return $this->morphOne(Post::class,'postable');
    }
}
