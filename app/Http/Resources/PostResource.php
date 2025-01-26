<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'user'=>new UserResource($this->user),
            'postID'=>$this->id,
            'caption'=> isset($this->postable->caption) ? $this->postable->caption : null ,
            'content'=>isset($this->postable->type) ? asset('/storage/posts/'.$this->postable->type."/".$this->postable->content) : $this->postable->content,
            'comments'=> CommentResource::collection($this->comments),
            'comments_count'=>$this->comments_count,
            'likes'=>LikeResource::collection($this->likes),
            'likes_count'=>$this->likes_count,
            'shared_posts_count'=>$this->shared_posts_count,
            'post time'=>Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
