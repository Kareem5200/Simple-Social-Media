<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MediaPost extends Model
{
    use HasFactory;
    public $table = 'image_posts';

    protected $fillable = [
        'caption',
        'content',
        'type',
    ];


    public function post(){
        return $this->morphOne(Post::class,'postable');
    }
}
