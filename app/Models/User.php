<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements JWTSubject , MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'phone_number',
        'profile_image',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

        // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }



    public function posts(){
        return $this->hasMany(Post::class,'user_id');
    }

  
    public function trashedPosts(){
        return $this->posts()->onlyTrashed();
    }

    public function comments(){
        return  $this->hasMany(Comment::class,'user_id');
    }
    public function sharedPosts(){
        return $this->hasMany(SharedPost::class,'user_id');
    }

    public function likes(){
        return $this->hasMany(Like::class,'user_id');
    }

    public function allFriends()
    {
        return $this->belongsToMany(User::class, 'friend_user', 'user_id', 'friend_id')
                    ->withPivot('status');
    }

    public function AcceptedFriends(){
        return $this->allFriends()->wherePivot('status','accepted');
    }

    public function pendingFriends(){
        return $this->allFriends()->wherePivot('status','pending');
    }

    public function blockedFriends(){
        return $this->allFriends()->wherePivot('status','blocked');
    }


    public function setPasswordAttribute($password){
        return $this->attributes['password']=Hash::make($password);
    }



}
