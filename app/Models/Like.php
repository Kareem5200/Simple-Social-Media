<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'user_id'
    ];



    public function likeable(){
        return $this->morphTo();
    }
    public function user(){
        return $this->BelongsTo(User::class,'user_id');
    }


    public function scopeUserLike($builder){
        return  $builder->where('user_id',auth()->id());
    }
}
