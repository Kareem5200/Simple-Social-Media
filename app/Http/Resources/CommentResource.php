<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'commentID'=>$this->id,
            'comment'=>$this->comment,
            'likes'=>LikeResource::collection($this->likes),
            'like_count'=>$this->comment_likes_count,
            'time'=>Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
