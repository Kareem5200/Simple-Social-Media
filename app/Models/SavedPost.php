<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedPost extends Model
{
    use HasFactory;

    public $table='saved_posts';
    protected $fillable=[
        'user_id',
        'post_id',
    ];

    public function user(){
        return $this->BelongsTo(User::class,'user_id');
    }

    public function post(){
        return $this->BelongsTo(Post::class,'post_id');
    }

}
