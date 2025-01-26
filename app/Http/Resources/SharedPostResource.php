<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SharedPostResource extends JsonResource
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
            'shared_post'=>[
                'caption'=>$this->caption,
                'comments'=>CommentResource::collection($this->comments),
                'comments_count'=>$this->comments_count,
                'likes'=> LikeResource::collection($this->likes),
                'likes_count'=>$this->likes_count,
                'post_time'=>Carbon::parse($this->created_at)->diffForHumans(),
            ],
            'main_post'=> new PostResource($this->post),
        ];
    }
}
