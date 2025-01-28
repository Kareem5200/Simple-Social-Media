<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'friend_id',
        'status'
    ];

    public function friendRequestRecevier(){
        return $this->belongsTo(User::class,'friend_id');
    }

    public function friendRequestSender(){
        return $this->belongsTo(User::class,'user_id');
    }

}
